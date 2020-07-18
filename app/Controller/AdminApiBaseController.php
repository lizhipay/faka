<?php
declare (strict_types=1);

namespace App\Controller;

/**
 * Class AdminApiBaseController
 * @package app\Controller
 */
abstract class AdminApiBaseController
{
    /**
     * 生成JSON格式
     * @param int $code
     * @param string|null $message
     * @param array|null $data
     * @return array
     */
    public function json(int $code, ?string $message = null, ?array $data = []): array
    {
        $json['code'] = $code;
        $message ? $json['msg'] = $message : null;
        $json['data'] = $data;
        return $json;
    }
}