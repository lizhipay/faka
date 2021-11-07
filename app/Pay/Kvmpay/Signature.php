<?php
declare (strict_types=1);

namespace App\Pay\Kvmpay;


use App\Pay\SignatureInterface;

class Signature implements SignatureInterface
{

    /**
     * 生成签名
     * @param array $post
     * @param string $key
     * @return string
     */
    public static function generateSignature(array $post, string $key): string
    {
        ksort($post);
        $sign = '';
        foreach ($post as $k => $v) {
            $sign .= $k . '=' . $v . '&';
        }
        $sign = trim($sign, '&');

        return md5($sign . $key);
    }

    /**
     * @inheritDoc
     */
    public function verification(array $post, array $config): bool
    {

        $sign = $post['sign'];
        unset($post['sign']);
        unset($post['sign_type']);

        $generateSignature = self::generateSignature($post, $config['key']);
        if ($sign != $generateSignature) {
            return false;
        }
        return true;
    }
}