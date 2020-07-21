<?php
declare (strict_types=1);

namespace App\Pay\Alipay;


use App\Entity\PayEntity;
use App\Pay\PayBase;
use App\Pay\PayInterface;
use Core\Exception\JSONException;
use Core\Utils\Bridge;

/**
 * Class Pay
 * @package App\Pay\Alipay
 */
class Pay extends PayBase implements PayInterface
{

    /**
     * @return PayEntity
     * @throws JSONException
     */
    public function trade(): PayEntity
    {
        if ($this->code == 1) {
            return $this->face();
        } else if ($this->code == 2) {
            return $this->pc();
        } else if ($this->code == 3) {
            return $this->wap();
        } else {
            throw new JSONException("秀儿啊");
        }
    }


    /**
     * @return PayEntity
     * @throws JSONException
     */
    private function face(): PayEntity
    {
        $params = new \Yurun\PaySDK\AlipayApp\Params\PublicParams;
        $params->appID = $this->config['app_id'];
        $params->appPrivateKey = $this->config['private_key'];
        $params->appPublicKey = $this->config['public_key'];
        $pay = new \Yurun\PaySDK\AlipayApp\SDK($params);
        // 支付接口
        $request = new \Yurun\PaySDK\AlipayApp\FTF\Params\QR\Request;
        $request->notify_url = $this->callbackUrl;
        $request->businessParams->out_trade_no = $this->tradeNo; // 商户订单号
        $request->businessParams->total_amount = $this->amount; // 价格
        $user = Bridge::getConfig('user');
        $request->businessParams->subject = '投诉联系QQ' . $user['qq']; //商品标题
        try {
            $data = $pay->execute($request);
            $qrcode = (string)$data['alipay_trade_precreate_response']['qr_code'];
            if ($qrcode == '') {
                throw new JSONException("下单失败，请联系客服");
            }
            $payEntity = new PayEntity();
            $payEntity->setType(self::TYPE_LOCAL);
            $payEntity->setUrl($qrcode);
            return $payEntity;
        } catch (\Exception $e) {
            throw new JSONException("下单失败，请联系客服");
        }
    }

    /**
     * @return PayEntity
     * @throws JSONException
     */
    private function pc(): PayEntity
    {
        $params = new \Yurun\PaySDK\AlipayApp\Params\PublicParams;
        $params->appID = $this->config['app_id'];
        $params->appPrivateKey = $this->config['private_key'];
        $params->appPublicKey = $this->config['public_key'];
        $user = Bridge::getConfig('user');
        $pay = new \Yurun\PaySDK\AlipayApp\SDK($params);
        // 支付接口
        $request = new \Yurun\PaySDK\AlipayApp\Page\Params\Pay\Request;
        $request->notify_url = $this->callbackUrl;
        $request->return_url = $this->returnUrl;
        $request->businessParams->out_trade_no = $this->tradeNo; // 商户订单号
        $request->businessParams->total_amount = $this->amount; // 价格
        $request->businessParams->subject = '投诉联系QQ' . $user['qq']; // 商品标题

        try {
            $pay->prepareExecute($request, $url);
            if ($url == '') {
                throw new JSONException("下单失败，请联系客服");
            }
            $payEntity = new PayEntity();
            $payEntity->setType(self::TYPE_JUMP);
            $payEntity->setUrl($url);
            return $payEntity;
        } catch (\Exception $e) {
            throw new JSONException("下单失败，请联系客服");
        }
    }

    /**
     * @return PayEntity
     * @throws JSONException
     */
    private function wap(): PayEntity
    {
        $params = new \Yurun\PaySDK\AlipayApp\Params\PublicParams;
        $params->appID = $this->config['app_id'];
        $params->appPrivateKey = $this->config['private_key'];
        $params->appPublicKey = $this->config['public_key'];
        $user = Bridge::getConfig('user');

        $pay = new \Yurun\PaySDK\AlipayApp\SDK($params);

        // 支付接口
        $request = new \Yurun\PaySDK\AlipayApp\Wap\Params\Pay\Request;

        $request->notify_url = $this->callbackUrl;
        $request->return_url = $this->returnUrl;
        $request->businessParams->out_trade_no = $this->tradeNo; // 商户订单号
        $request->businessParams->total_amount = $this->amount; // 价格
        $request->businessParams->subject = '投诉联系QQ' . $user['qq'];// 商品标题

        try {
            $pay->prepareExecute($request, $url);
            if ($url == '') {
                throw new JSONException("下单失败，请联系客服");
            }
            $payEntity = new PayEntity();
            $payEntity->setType(self::TYPE_JUMP);
            $payEntity->setUrl($url);
            return $payEntity;
        } catch (\Exception $e) {
            throw new JSONException("下单失败，请联系客服");
        }
    }


}