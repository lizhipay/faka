<?php
declare (strict_types=1);

namespace App\Service;

/**
 * Interface VersionServiceInterface
 * @package app\Service
 */
interface VersionServiceInterface
{
    /**
     * 获取版本信息
     * @return mixed
     */
    public function getVersionInfo(): array;


    /**
     * 版本更新
     */
    public function update(): void;
}