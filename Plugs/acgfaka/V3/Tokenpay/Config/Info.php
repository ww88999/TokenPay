<?php
declare (strict_types=1);

return [
    'version' => '1.0.0',
    'name' => 'TokenPay',
    'author' => 'ai_dianpu',
    'website' => '#',
    'description' => 'TokenPay',
    'options' => [
        'tokenpay' => '默认接口',
    ],
    'callback' => [
        \App\Consts\Pay::IS_SIGN => true,
        \App\Consts\Pay::IS_STATUS => true,
        \App\Consts\Pay::FIELD_STATUS_KEY => 'status',
        \App\Consts\Pay::FIELD_STATUS_VALUE => 2,
        \App\Consts\Pay::FIELD_ORDER_KEY => 'order_id',
        \App\Consts\Pay::FIELD_AMOUNT_KEY => 'amount',
        \App\Consts\Pay::FIELD_RESPONSE => 'ok'
    ]
];
