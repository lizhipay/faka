<?php
declare (strict_types=1);

namespace App\Service;

/**
 * Interface PayServiceInterface
 * @package App\Service
 */
interface PayServiceInterface
{
    /**
     * 获取平台列表
     * @return array
     */
    public function getPlatforms(): array;

    /**
     * 获取平台信息
     * @param string $handle
     * @return array
     */
    public function getPlatformInfo(string $handle): array;
}