<?php
declare (strict_types=1);

return [
    'name' => 'Kvmpay',
    'site' => 'https://doc.kvmpay.cn/',
    'desc' => '一个超简单免挂监控的码支付系统，支付宝/微信/QQ钱包',
    'list' => [
        'alipay' => '支付宝',
        'wxpay' => '微信',
        'qqpay' => 'QQ钱包',
    ],
    'callback' => [
        'isSign' => true,
        'status' => 'trade_status',
        'statusValue' => "TRADE_SUCCESS",
        'isStatus' => true,
        'tradeNo' => 'out_trade_no',
        'amount' => 'money',
        'return' => 'success'
    ]
];