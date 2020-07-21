<?php
declare (strict_types=1);

namespace App\Pay\Alipay;


use App\Pay\SignatureInterface;

class Signature implements SignatureInterface
{

    /**
     * @inheritDoc
     */
    public function verification(array $post, array $config): bool
    {
        $params = new \Yurun\PaySDK\AlipayApp\Params\PublicParams;
        $params->appPrivateKey = $config['private_key'];
        $params->appPublicKey = $config['public_key'];
        $pay = new \Yurun\PaySDK\AlipayApp\SDK($params);
        try {
            if ($pay->verifyCallback($post)) {
                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            return false;
        }
    }
}