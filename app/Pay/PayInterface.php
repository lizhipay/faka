<?php
declare (strict_types=1);

namespace App\Pay;

use App\Entity\PayEntity;

/**
 * 支付接口类
 * Interface PayInterface
 * @package app\Pay
 */
interface PayInterface
{
    /**
     * 跳转提交
     */
    const TYPE_JUMP = 2;

    /**
     * 本地渲染支付页
     */
    const TYPE_LOCAL = 3;

    /**
     * 下单，返回支付地址
     * @return PayEntity
     */
    public function trade(): PayEntity;
}