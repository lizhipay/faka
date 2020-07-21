<?php
declare (strict_types=1);

namespace App\Pay\LiZhi;


use App\Entity\PayEntity;
use App\Pay\LiZhi\Utils\StringUtil;
use App\Pay\PayBase;
use App\Pay\PayInterface;
use App\Utils\HttpUtil;
use Core\Exception\JSONException;

/**
 * Class Pay
 * @package app\Pay\Alipay
 */
class Pay extends PayBase implements PayInterface
{

    /**
     * @return PayEntity
     * @throws JSONException
     */
    public function trade(): PayEntity
    {
        $postData = [
            'merchant_id' => $this->config['merchant_id'],
            'amount' => $this->amount,
            'channel_id' => $this->code,
            'app_id' => $this->config['app_id'],
            'notification_url' => $this->callbackUrl,
            'sync_url' => $this->returnUrl,
            'ip' => $this->clientIp,
            'out_trade_no' => $this->tradeNo
        ];
        $postData['sign'] = StringUtil::generateSignature($postData, $this->config['key']);
        $request = HttpUtil::request(trim($this->config['url'], "/") . '/order/trade', $postData);
        $json = json_decode((string)$request, true);
        if ($json['code'] != 200) {
            throw new JSONException($json['msg']);
        }
        $url = $json['data']['url'];
        $payEntity = new PayEntity();
        $payEntity->setType(self::TYPE_JUMP);
        $payEntity->setUrl($url);
        return $payEntity;
    }
}