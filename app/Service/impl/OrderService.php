<?php
declare (strict_types=1);

namespace App\Service\impl;


use App\Entity\PayEntity;
use App\Model\Card;
use App\Model\Commodity;
use App\Model\Order;
use App\Model\Pay;
use App\Model\Voucher;
use App\Pay\PayInterface;
use App\Service\OrderServiceInterface;
use App\Utils\AddressUtil;
use App\Utils\DateUtil;
use App\Utils\EmailUtil;
use App\Utils\StringUtil;
use Core\Exception\JSONException;
use Core\Utils\Bridge;
use Illuminate\Database\Capsule\Manager as DB;

/**
 * Class OrderService
 * @package App\Service\impl
 */
class OrderService implements OrderServiceInterface
{

    /**
     * @inheritDoc
     * @throws JSONException
     */
    public function trade(string $contact, int $num, string $pass, int $payId, int $device, string $voucher, int $commodityId, string $ip, array $post): array
    {
        if ($commodityId == 0) {
            throw new JSONException('请选择商品再进行下单');
        }

        if ($num <= 0) {
            throw new JSONException("最低购买数量为1~");
        }

        //查询商品
        $commodity = Commodity::query()->find($commodityId);

        if (!$commodity) {
            throw new JSONException("商品不存在");
        }

        if ($commodity->status != 1) {
            throw new JSONException("当前商品已停售，请稍后再试");
        }

        if (mb_strlen($contact) < 4) {
            throw new JSONException("联系方式不能低于4个字符");
        }

        $regx = ['', '/^1[3456789]\d{9}$/', '/.*(.{2}@.*)$/i', '/[1-9]{1}[0-9]{4,11}/'];
        $msg = ['', '手机', '邮箱', 'QQ号'];
        if ($commodity->contact != 0) {
            if (!preg_match($regx[$commodity->contact], $contact)) {
                throw new JSONException("您输入的{$msg[$commodity->contact]}格式不正确！");
            }
        }

        //开始构建自定义信息
        $inputExt = (array)json_decode((string)$commodity->input_ext, true);
        $orderExt = [];
        if (count($inputExt) > 0) {
            foreach ($inputExt as $item) {
                $value = $post[$item['name']];
                if ($item['type'] == 'checkbox') {
                    $value = (array)$value;
                    if ($item['required'] == 1 && count($value) == 0) {
                        throw new JSONException($item['title'] . '不能为空');
                    }
                } else {
                    //验证是否检测空
                    if ($item['required'] == 1 && $value === "") {
                        throw new JSONException($item['title'] . '不能为空');
                    }
                    //正则验证
                    if ($item['regx'] != "" && $item['regx'] != null) {
                        if (!preg_match("/{$item['regx']}/", $value)) {
                            throw new JSONException($item['error']);
                        }
                    }
                }
                $orderExt[] = ['name' => $item['name'], 'type' => $item['type'], 'title' => $item['title'], 'value' => $value];
            }
        }

        if ($commodity->card_type == 0) {
            //检测库存
            $count = Card::query()->where("commodity_id", $commodityId)->where("status", 0)->count();
            if ($count == 0 || $num > $count) {
                throw new JSONException("当前商品库存不足，请稍后再试~");
            }
        }

        //开始计算订单金额
        $amount = $this->getAmount($num, $commodity);

        //获取支付方式
        $pay = Pay::query()->find($payId);

        if (!$pay) {
            throw new JSONException("该支付方式不存在");
        }

        if ($pay->status != 1) {
            throw new JSONException("当前支付方式已停用，请换个支付方式再进行支付");
        }


        //创建订单
        return DB::transaction(function () use ($amount, $commodity, $payId, $commodityId, $ip, $device, $pass, $contact, $voucher, $num, $pay, $orderExt) {
            $date = DateUtil::current();
            $order = new Order();
            $order->trade_no = StringUtil::generateTradeNo();
            $order->amount = $amount;
            $order->pay_id = $payId;
            $order->commodity_id = $commodityId;
            $order->create_date = $date;
            $order->create_ip = $ip;
            $order->create_device = $device;
            $order->contact = $contact;
            $order->status = 0;
            $order->num = $num;
            $order->send = 0;

            if (!empty($orderExt)) {
                $order->exts = json_encode($orderExt, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            }

            if ($pass != '') {
                $order->pass = $pass;
            }

            //获取优惠卷
            if (mb_strlen($voucher) == 8) {
                $voucherModel = Voucher::query()->where("commodity_id", $commodityId)->where("voucher", $voucher)->first();
                if (!$voucherModel) {
                    throw new JSONException("该优惠卷不存在或不属于该商品");
                }
                if ($voucherModel->status != 0) {
                    throw new JSONException("该优惠卷已被使用过了");
                }

                if ($voucherModel->money > $amount) {
                    throw new JSONException("该优惠卷抵扣的金额大于本次消费，无法使用该优惠卷进行抵扣");
                }

                //进行优惠
                $order->amount = $amount - $voucherModel->money;

                $voucherModel->status = 1;
                $voucherModel->contact = $contact;
                $voucherModel->use_date = $date;
                $voucherModel->save();

                $order->voucher_id = $voucherModel->id;
            }

            $url = '';

            //判断金额，检测是否为免费订单
            if ($order->amount == 0) {
                if ($num > 1) {
                    throw new JSONException("当前商品是免费商品，一次性最多领取1个");
                }

                $order->status = 1;
                $order->pay_date = $date;

                //判断自动发货
                if ($commodity->card_type == 0) {
                    //取出对应的密钥
                    $card = Card::query()->where("commodity_id", $commodityId)->where("status", 0)->first();
                    if (!$card) {
                        throw new JSONException("您的手慢了，商品被抢空");
                    }
                    $card->status = 1;
                    $card->contact = $contact;
                    $card->buy_date = $date;
                    $card->save();
                    $order->commodity = $card->card;
                    $order->send = 1;

                    //发送邮件
                    if ($commodity->email_notification == 1 && $commodity->card_type == 0 && $commodity->contact == 2) {
                        $siteConfig = Bridge::getConfig('site');
                        $emailConfig = Bridge::getConfig('email');
                        EmailUtil::send($emailConfig, $siteConfig['title'], $order->commodity, $commodity->name, $order->contact);
                    }
                } else {
                    $user = Bridge::getConfig('user');
                    $message = ($commodity->delivery_message != null && $commodity->delivery_message != "") ? $commodity->delivery_message : '正在发货中，请耐心等待，如有疑问，请联系客服QQ：' . $user['qq'];
                    $order->commodity = $message;
                }
            } else {
                //支付类
                $class = "\\App\\Pay\\{$pay->handle}\\Pay";
                if (!class_exists($class)) {
                    throw new JSONException("该支付方式未实现接口，无法使用");
                }
                $payObject = new $class;
                $payObject->amount = $order->amount;
                $payObject->tradeNo = $order->trade_no;
                $payObject->config = Bridge::getPayConfig($pay->handle);
                $payObject->callbackUrl = AddressUtil::getUrl() . '/index/api/order/callback@handle=' . $pay->handle;
                $payObject->returnUrl = AddressUtil::getUrl() . '/index/query?tradeNo=' . $order->trade_no;
                $payObject->clientIp = $ip;
                $payObject->code = $pay->code;
                $trade = $payObject->trade();

                if ($trade instanceof PayEntity) {
                    $order->payUrl = $trade->getUrl();

                    switch ($trade->getType()) {
                        case PayInterface::TYPE_JUMP:
                            $url = $order->payUrl;
                            break;
                        case PayInterface::TYPE_LOCAL:
                            $url = '/index/pay/?handle=' . $pay->handle . '&code=' . $pay->code . '&tradeNo=' . $order->trade_no;
                            break;
                    }

                } else {
                    throw new JSONException("支付方式未部署成功");
                }
            }
            $order->save();

            return ['url' => $url, 'amount' => $order->amount, 'tradeNo' => $order->trade_no];
        });
    }

    /**
     * 获取购买价格
     * @param int $num
     * @param Commodity $commodity
     * @return float
     */
    private function getAmount(int $num, Commodity $commodity): float
    {
        $price = $commodity->price;
        if ($commodity->wholesale_status == 1) {
            $list = [];
            $wholesales = explode(PHP_EOL, trim(trim((string)$commodity->wholesale), PHP_EOL));
            foreach ($wholesales as $item) {
                $s = explode('-', $item);
                if (count($s) == 2) {
                    $list[$s[0]] = $s[1];
                }
            }
            krsort($list);
            foreach ($list as $k => $v) {
                if ($num >= $k) {
                    $price = $v;
                    break;
                }
            }
        }
        return $num * $price;
    }


    /**
     * @inheritDoc
     * @throws JSONException
     */
    public function getTradeAmount(int $num, string $voucher, int $commodityId): array
    {

        if ($num <= 0) {
            throw new JSONException("购买数量不能低于1个");
        }

        //查询商品
        $commodity = Commodity::query()->find($commodityId);

        if (!$commodity) {
            throw new JSONException("商品不存在");
        }

        if ($commodity->status != 1) {
            throw new JSONException("当前商品已停售，请稍后再试");
        }

        //获取单价
        $amount = $this->getAmount($num, $commodity);
        $price = $amount / $num;
        $voucherAmount = 0;

        //获取优惠卷
        if (mb_strlen($voucher) == 8) {
            $voucherModel = Voucher::query()->where("commodity_id", $commodityId)->where("voucher", $voucher)->first();

            if (!$voucherModel) {
                throw new JSONException("该优惠卷不存在或不属于该商品");
            }

            if ($voucherModel->status != 0) {
                throw new JSONException("该优惠卷已被使用过了");
            }

            if ($voucherModel->money > $amount) {
                throw new JSONException("该优惠卷抵扣的金额大于本次消费，无法使用该优惠卷进行抵扣");
            }

            //进行优惠
            $amount = $amount - $voucherModel->money;
            $voucherAmount = $voucherModel->money;
        }

        return ['price' => $price, 'amount' => $amount, 'voucher' => $voucherAmount];
    }

    /**
     * @inheritDoc
     * @throws JSONException
     */
    public function callback(string $handle, array $map): string
    {
        $payInfo = Bridge::getPayInfo($handle);
        $payConfig = Bridge::getPayConfig($handle);
        $callback = $payInfo['callback'];
        $user = Bridge::getConfig('user');
        if ($callback['isSign']) {
            $class = "\\App\\Pay\\{$handle}\\Signature";
            if (!class_exists($class)) {
                throw new JSONException("Signature Not implements Interface");
            }
            $signature = new $class;
            if (!$signature->verification($map, $payConfig)) {
                throw new JSONException("sign error");
            }
        }

        if ($callback['isStatus']) {
            //验证状态
            if ($map[$callback['status']] != $callback['statusValue']) {
                return 'status error';
            }
        }

        $order = DB::transaction(function () use ($map, $user, $callback) {
            //获取订单
            $order = Order::query()->where("trade_no", $map[$callback['tradeNo']])->where("status", 0)->first();

            if (!$order) {
                throw new JSONException("order not found");
            }

            if ($order->amount != $map[$callback['amount']]) {
                throw new JSONException("amount error");
            }

            $shop = $order->shop;
            $order->pay_date = DateUtil::current();
            $order->status = 1;

            if ($shop->card_type == 0) {
                //取出和订单相同数量的卡密
                $cards = Card::query()->where("commodity_id", $order->commodity_id)->where("status", 0)->limit($order->num)->get();
                if (count($cards) != $order->num) {
                    $order->commodity = '很抱歉，当前库存不足，自动发卡失败，请联系客服QQ：' . $user['qq'];
                } else {
                    //将全部卡密置已销售状态
                    $ids = [];
                    $cardc = '';
                    foreach ($cards as $card) {
                        $ids[] = $card->id;
                        $cardc .= $card->card . PHP_EOL;
                    }
                    try {
                        $rows = Card::query()->whereIn("id", $ids)->update(['buy_date' => $order->pay_date, 'contact' => $order->contact, 'status' => 1]);
                        if ($rows == 0) {
                            $order->commodity = '很抱歉，当前库存不足，自动发卡失败，请联系客服QQ：' . $user['qq'];
                        } else {
                            //将卡密写入到订单中
                            $order->commodity = trim($cardc, PHP_EOL);
                        }
                    } catch (\Exception $e) {
                        $order->commodity = '很抱歉，当前库存不足，自动发卡失败，请联系客服QQ：' . $user['qq'];
                    }
                }
                $order->send = 1;
            } else {
                //手动发货
                $message = ($shop->delivery_message != null && $shop->delivery_message != "") ? $shop->delivery_message : '正在发货中，请耐心等待，如有疑问，请联系客服QQ：' . $user['qq'];
                $order->commodity = $message;
            }

            $order->save();
            return $order;
        });

        //获取商品
        $shop = $order->shop;
        //检测是否需要发邮件
        if ($shop->email_notification == 1 && $shop->card_type == 0 && $shop->contact == 2) {
            $siteConfig = Bridge::getConfig('site');
            $emailConfig = Bridge::getConfig('email');
            EmailUtil::send($emailConfig, $siteConfig['title'], $order->commodity, $shop->name, $order->contact);
        }

        return $callback['return'];
    }
}