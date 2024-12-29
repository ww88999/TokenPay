<?php
declare(strict_types=1);

namespace App\Pay\Tokenpay\Impl;

use App\Entity\PayEntity;
use App\Pay\Base;
use GuzzleHttp\Exception\GuzzleException;
use Kernel\Exception\JSONException;

/**
 * Class Pay
 * @package App\Pay\Kvmpay\Impl
 */
class Pay extends Base implements \App\Pay\Pay
{

    /**
     * @return PayEntity
     * @throws JSONException
     */
    public function trade(): PayEntity
    {

        if (!$this->config['url']) {
            throw new JSONException("请配置网关地址");
        }

        if (!$this->config['key']) {
            throw new JSONException("请配置密钥");
        }

        if (!$this->config['typename']) {
            throw new JSONException("请配置货币类型");
        }

	$param = [
	    'OutOrderId' => $this->tradeNo, //外部订单号
        'OrderUserKey' => $this->tradeNo,
	    'ActualAmount' => $this->amount,   //订单实际支付的人民币金额，保留两位小数
	    'Currency' => $this->config['typename'],   //加密货币的币种，直接以原样字符串传递即可
	    'NotifyUrl' => $this->callbackUrl,  //异步通知URL
	    'RedirectUrl' => $this->returnUrl,    //订单支付或过期后跳转的URL
            'Timestamp'    => time(), // 增加时间戳参数
	];
        
        $param['signature'] = Signature::generateSignature($param, $this->config['key']);

        try {
            $request = $this->http()->post(trim($this->config['url'], "/") . '/CreateOrder', [
            'headers' => [
                'Content-Type' => 'application/json'
            ],
                'body' => json_encode($param),
            ]);
        } catch (GuzzleException $e) {
            throw new JSONException("网关连接失败，下单未成功");
        }

        $contents = $request->getBody()->getContents();
        $json = (array)json_decode((string)$contents, true);
        if (!isset($json['success']) || !$json['success']) {
            throw new JSONException("支付网关异常". $json['message']);
        }

        $payEntity = new PayEntity();
        $payEntity->setType(self::TYPE_REDIRECT);
        $payEntity->setUrl($json['data']);
        return $payEntity;
    }
}
