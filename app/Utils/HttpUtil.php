<?php
declare (strict_types=1);

namespace App\Utils;

/**
 * Class HttpUtil
 * @package App\Utils
 */
class HttpUtil
{
    /**
     * 发起POST请求
     * @param $url
     * @param null $data
     * @return bool|string
     */
    public static function request($url, $data = null)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        if (!empty($data)) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
        $content = curl_exec($ch);
        curl_close($ch);
        return $content;
    }
}