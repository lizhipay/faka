<?php
declare(strict_types=1);

namespace App\Utils;

/**
 * Class AesUtil
 * @package App\Utils
 */
class AesUtil
{
    /**
     * AES/CBC 加密
     * @param $data
     * @param $encryptKey
     * @param $localIV
     * @return string
     */
    public static function encrypt($data, $encryptKey, $localIV)
    {
        return base64_encode(openssl_encrypt($data, 'aes-128-cbc', $encryptKey, OPENSSL_RAW_DATA, $localIV));
    }

    /**
     * AES/CBC 解密
     * @param $data
     * @param $encryptKey
     * @param $localIV
     * @return bool|string
     */
    public static function decrypt($data, $encryptKey, $localIV)
    {
        return openssl_decrypt(base64_decode($data), 'aes-128-cbc', $encryptKey, 1, $localIV);
    }
}