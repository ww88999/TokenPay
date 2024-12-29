[
    {
        name: util.icon("icon-waibuduijie") + " 对接配置",
        form: [
            {
                title: "选择货币",
                name: "pid",
                type: "radio",
                dict: [
                    {id : 0, name:"USDT_TRC20"},
                    {id : 1, name:"TRX"},
                    {id : 2, name:"EVM_ETH_ETH"},
                    {id : 3, name:"EVM_ETH_USDT_ERC20"},
                    {id : 4, name:"EVM_ETH_USDC_ERC20"},
                    {id : 5, name:"EVM_BSC_BNB"},
                    {id : 6, name:"EVM_BSC_USDT_BEP20"},
                    {id : 7, name:"EVM_BSC_USDC_BEP20"},
                    {id : 8, name:"EVM_Polygon_POL"},
                    {id : 9, name:"EVM_Polygon_USDT_ERC20"},
                    {id : 10, name:"EVM_Polygon_USDC_ERC20"},
                    {id : 11, name:"EVM_Polygon_POL"},
                ],
            },
            {
                title: "支付网关",
                name: "url",
                type: "input",
                placeholder: "支付网关地址(如:https://abcedf.com)"
            },
            {
                title: "密钥",
                name: "key",
                type: "input",
                placeholder: "请输入密钥"
            }
        ]
    }
]
