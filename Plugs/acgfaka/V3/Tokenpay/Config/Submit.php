<?php
declare (strict_types=1);

return [
    [
        "title" => "货币类型",
        "name" => "typename",
        "type" => "select",
        "placeholder" => "选择货币",
        "dict" => [
            ["id" => "USDT_TRC20","name"=>"USDT_TRC20"],
            ["id" => "TRX","name"=>"TRX"],
            ["id" => "EVM_ETH_ETH","name"=>"EVM_ETH_ETH"],
            ["id" => "EVM_ETH_USDT_ERC20","name"=>"EVM_ETH_USDT_ERC20"],
            ["id" => "EVM_ETH_USDC_ERC20","name"=>"EVM_ETH_USDC_ERC20"],
            ["id" => "EVM_BSC_BNB","name"=>"EVM_BSC_BNB"],
            ["id" => "EVM_BSC_USDT_BEP20","name"=>"EVM_BSC_USDT_BEP20"],
            ["id" => "EVM_BSC_USDC_BEP20","name"=>"EVM_BSC_USDC_BEP20"],
            ["id" => "EVM_Polygon_POL","name"=>"EVM_Polygon_POL"],
            ["id" => "EVM_Polygon_USDT_ERC20","name"=>"EVM_Polygon_USDT_ERC20"],
            ["id" => "EVM_Polygon_USDC_ERC20","name"=>"EVM_Polygon_USDC_ERC20"],
            ["id" => "EVM_Polygon_POL","name"=>"EVM_Polygon_POL"],
        ]
    ],  
    [
        "title" => "支付网关",
        "name" => "url",
        "type" => "input",
        "placeholder" => "支付网关地址"
    ],
    [
        "title" => "密钥",
        "name" => "key",
        "type" => "input",
        "placeholder" => "密钥"
    ],
];
