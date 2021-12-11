<?php
declare (strict_types=1);

return [
    'name' => '易支付',
    'site' => '#',
    'desc' => '支持易支付协议',
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