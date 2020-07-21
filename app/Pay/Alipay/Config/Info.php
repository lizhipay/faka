<?php
declare (strict_types=1);

return [
    'name' => '支付宝官方',
    'site' => 'https://www.alipay.com',
    'desc' => '支付宝是一家良心的企业，使用他们的支付都是需要企业签约的。',
    'list' => [
        1 => '当面付',
        2 => '电脑网站支付',
        3 => '手机网站支付'
    ],
    'callback' => [
        'isSign' => true,
        'status' => 'status',
        'statusValue' => '',
        'isStatus' => false,
        'tradeNo' => 'out_trade_no',
        'amount' => 'total_amount',
        'return' => 'success'
    ]
];