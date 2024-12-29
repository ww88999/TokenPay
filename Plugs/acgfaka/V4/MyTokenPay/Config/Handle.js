[
    {
        name: util.icon("icon-waibuduijie") + " 对接配置",
        form: [
            {
                title: "选择货币",
                name: "pid",
                type: "radio",
                dict: [
                    {id : "USDT_TRC20", name:"USDT_TRC20"},
                    {id : "TRX", name:"TRX"},
                    {id : "EVM_ETH_ETH", name:"EVM_ETH_ETH"},
                    {id : "EVM_ETH_USDT_ERC20", name:"EVM_ETH_USDT_ERC20"},
                    {id : "EVM_ETH_USDC_ERC20", name:"EVM_ETH_USDC_ERC20"},
                    {id : "EVM_BSC_BNB", name:"EVM_BSC_BNB"},
                    {id : "EVM_BSC_USDT_BEP20", name:"EVM_BSC_USDT_BEP20"},
                    {id : "EVM_BSC_USDC_BEP20", name:"EVM_BSC_USDC_BEP20"},
                    {id : "EVM_Polygon_POL", name:"EVM_Polygon_POL"},
                    {id : "EVM_Polygon_USDT_ERC20", name:"EVM_Polygon_USDT_ERC20"},
                    {id : "EVM_Polygon_USDC_ERC20", name:"EVM_Polygon_USDC_ERC20"},
                    {id : "EVM_Polygon_POL", name:"EVM_Polygon_POL"},
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
