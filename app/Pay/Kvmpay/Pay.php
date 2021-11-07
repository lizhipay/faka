<?php
declare (strict_types=1);

namespace App\Pay\Kvmpay;


use App\Entity\PayEntity;
use App\Pay\PayBase;
use App\Pay\PayInterface;

/**
 * Class Pay
 * @package app\Pay\Kvmpay
 */
class Pay extends PayBase implements PayInterface
{

    /**
     * @return PayEntity
     */
    public function trade(): PayEntity
    {
        $param = [
            'pid' => $this->config['pid'],
            'name' => $this->tradeNo, //订单名称
            'type' => $this->code,
            'money' => $this->amount,
            'out_trade_no' => $this->tradeNo,
            'notify_url' => $this->callbackUrl,
            'return_url' => $this->returnUrl,
            'sitename' => 'OTAKU',
        ];
        $param['sign'] = Signature::generateSignature($param, $this->config['key']);
        $param['sign_type'] = "MD5";


        $data = "<form id='alipaysubmit' name='alipaysubmit' method='post' action='{$this->config['url']}'>";

        foreach ($param as $k => $v) {
            $data .= "<input type='hidden' name='{$k}' value='{$v}'>";
        }

        $data .= "<input type='submit' value='正在发起支付....'></form ><script >document.forms['alipaysubmit'].submit();</script>";

        $payEntity = new PayEntity();
        $payEntity->setType(self::TYPE_LOCAL);
        $payEntity->setUrl($data);
        return $payEntity;
    }
}