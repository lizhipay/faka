<?php
declare (strict_types=1);

return [
    'name' => '荔枝付',
    'site' => 'https://lizhifu.net',
    'desc' => '荔枝付是一个兼备“易支付”以及“码支付”所有功能为一体的支付平台。',
    'list' => [
        101 => '支付宝-H5',
        105 => '支付宝-当面付',
        106 => '微信-扫码',
        107 => '微信-转账',
        108 => '支付宝-PC扫码',
        109 => '支付宝-WAP支付'
    ],
    'callback' => [
        'isSign' => true,
        'status' => 'status',
        'statusValue' => 1,
        'isStatus' => true,
        'tradeNo' => 'out_trade_no',
        'amount' => 'amount',
        'return' => 'success'
    ]
];