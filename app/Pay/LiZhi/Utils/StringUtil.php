<?php
declare (strict_types=1);

namespace App\Pay\LiZhi\Utils;

/**
 * Class StringUtil
 * @package App\Pay\LiZhi\Utils
 */
class StringUtil
{

    /**
     * 获取数据签名
     * @param array $data
     * @param string $appKey
     * @return string
     */
    public static function generateSignature(array $data, string $appKey): string
    {
        unset($data['sign']);
        ksort($data);
        foreach ($data as $key => $val) {
            if ($val === '') {
                unset($data[$key]);
            }
        }
        return md5(urldecode(http_build_query($data) . "&key=" . $appKey));
    }
}