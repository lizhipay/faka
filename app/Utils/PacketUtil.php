<?php
declare(strict_types=1);

namespace App\Utils;


use App\Exception\HexException;

/**
 * Class PacketUtil
 * @package App\Utils
 */
class PacketUtil
{

    /**
     * 加密数组，返回序列化数据
     * @param array $data
     * @return string
     */
    public static function packArray(array $data): string
    {
        $pack = self::pack(http_build_query($data));
        return serialize($pack);
    }


    /**
     * 解密数组
     * @param string $data
     * @return array
     */
    public static function unpageArray(string $data): array
    {
        $unserialize = (array)unserialize($data);
        $unpack = self::unpack($unserialize);
        return $unpack;
    }

    /**
     * 分解数据
     * 格式化数据
     * @param array $data
     * @return array
     */
    public static function unpack(array $data)
    {
        if (!$data['_s'] || !$data['_v'] || !$data['_x']) {  // _s = token ,  _v = secret , _x = data
            throw new HexException("异常数据包");
        }
        //token
        $token = substr(md5(substr($data['_s'], 8, 16) . substr($data['_s'], 0, 8)), 0, 16);
        //secret
        $secret = substr(md5(substr($data['_v'], 8, 16) . substr($data['_v'], 0, 8)), 0, 16);
        //解析数据
        $post = AesUtil::decrypt($data['_x'], $token, $secret);
        $packet = [];
        parse_str($post, $packet);
        return $packet;
    }

    /**
     * 分解数据
     * 格式化数据
     * @param array $data
     * @return bool|string
     */
    public static function unpacks(array $data)
    {
        if (!$data['_s'] || !$data['_v'] || !$data['_x']) {  // _s = token ,  _v = secret , _x = data
            throw new HexException("异常数据包");
        }
        //token
        $token = substr(md5(substr($data['_s'], 8, 16) . substr($data['_s'], 0, 8)), 0, 16);
        //secret
        $secret = substr(md5(substr($data['_v'], 8, 16) . substr($data['_v'], 0, 8)), 0, 16);
        //解析数据
        return AesUtil::decrypt($data['_x'], $token, $secret);
    }

    /**
     * 加密数据，返回待解密数组
     * @param string $content
     * @return array
     */
    public static function pack(string $content)
    {
        //生成密钥
        $token = substr(md5((string)time()), 0, 16);
        //生成偏移量
        $iv = substr(md5(time() . mt_rand(1, 9)), 0, 16);
        //重新排列
        $tf = substr(md5(substr($token, 8, 16) . substr($token, 0, 8)), 0, 16);
        $vf = substr(md5(substr($iv, 8, 16) . substr($iv, 0, 8)), 0, 16);

        $ender = AesUtil::encrypt($content, $tf, $vf);

        $data = [
            '_x' => $ender,
            '_s' => $token,
            '_v' => $iv
        ];

        return $data;
    }
}