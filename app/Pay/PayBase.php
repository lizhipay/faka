<?php
declare (strict_types=1);

namespace App\Pay;


abstract class PayBase
{

    /**
     * 支付金额
     * @var float
     */
    public $amount;

    /**
     * 订单信息
     * @var string
     */
    public $tradeNo;

    /**
     * 配置信息
     * @var array
     */
    public $config;

    /**
     * 回调地址
     * @var string
     */
    public $callbackUrl;

    /**
     * 跳转地址
     * @var string
     */
    public $returnUrl;

    /**
     * 客户IP地址
     * @var string
     */
    public $clientIp;

    /**
     * 通道编码
     * @var string
     */
    public $code;
}