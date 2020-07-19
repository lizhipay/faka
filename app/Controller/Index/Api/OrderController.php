<?php
declare (strict_types=1);

namespace app\Controller\Index\Api;


use App\Controller\IndexBaseController;
use App\Model\Order;
use App\Service\OrderServiceInterface;
use App\Utils\AddressUtil;
use Core\Exception\JSONException;

/**
 * Class OrderController
 * @package app\Controller\Index\Api
 */
class OrderController extends IndexBaseController
{

    /**
     * @Inject
     * @var OrderServiceInterface
     */
    public $orderService;

    /**
     * 下单
     * @param string $contact
     * @param $num
     * @param string|null $pass
     * @param $payId
     * @param $device
     * @param $voucher
     * @param $commodityId
     * @return array
     */
    public function trade($contact, $num, $pass, $payId, $device, $voucher, $commodityId): array
    {
        $order = $this->orderService->trade((string)$contact, (int)$num, (string)$pass, (int)$payId, (int)$device, (string)$voucher, (int)$commodityId, AddressUtil::getClient(), $_POST);
        return $this->json(200, '下单成功', $order);
    }


    /**
     * 订单查询
     * @param $keywords
     * @param $pass
     * @return array
     * @throws JSONException
     */
    public function query($keywords): array
    {
        $keywords = trim((string)$keywords);
        $filed = ['id', 'trade_no', 'amount', 'pay_id', 'commodity_id', 'create_date', 'pay_date', 'status', 'num', 'contact', 'voucher_id'];

        $order = Order::query()->where("trade_no", $keywords)->with(['pay', 'voucher', 'commodity'])->get($filed);
        if (count($order) == 0) {
            $order = Order::query()->where("contact", $keywords)->with(['pay', 'voucher', 'commodity'])->orderBy("id", "desc")->limit(10)->get($filed);
        }

        if (count($order) == 0) {
            throw new JSONException("未查询到相关信息");
        }
        //回显订单信息
        return $this->json(200, 'success', $order->toArray());
    }

    /**
     * 获取卡密信息
     * @param $orderId
     * @param $pass
     * @return array
     * @throws JSONException
     */
    public function getCard($orderId, $pass): array
    {
        $order = Order::query()->find((int)$orderId);

        if (!$order) {
            throw new JSONException("未查询到相关信息");
        }

        if ($order->pass != null && $order->pass != "") {
            if ($pass != $order->pass) {
                throw new JSONException("密码错误", -7);
            }
        }

        if ($order->status != 1) {
            throw new JSONException("该订单还未支付，没有卡密信息");
        }

        return $this->json(200, 'success', ['card' => $order->commodity]);
    }


    /**
     * 订单回调
     * @return string
     */
    public function callback(): string
    {
        return $this->orderService->callback($_POST);
    }

}