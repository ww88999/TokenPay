<?php
declare (strict_types=1);

namespace App\Plugin\MyTokenPay\Handle;

use Kernel\Context\Interface\Response;
use Kernel\Exception\HandleException;
use Kernel\Exception\JSONException;
use Kernel\Util\Http;
use Kernel\Util\UserAgent;

class Pay extends \Kernel\Plugin\Abstract\Pay
{


    /**
     * @return \Kernel\Plugin\Entity\Pay
     * @throws HandleException
     * @throws JSONException
     * @throws \ReflectionException
     */
    public function create(): \Kernel\Plugin\Entity\Pay
    {
        if (!$this->config['url']) {
            throw new JSONException("请配置TokenPay网关地址");
        }
        if (!$this->config['key']) {
            throw new JSONException("请配置密钥");
        }
        if (!$this->config['pid']) {
            throw new JSONException("请配置货币类型");
        }
        $this->config['typename'] = $this->config['pid'];

        $param = [
            'OutOrderId' => $this->order->trade_no,
            'OrderUserKey' => $this->order->trade_no,
            'ActualAmount' => $this->amount,
            'Currency' => $this->config['typename'],   //加密货币的币种，直接以原样字符串传递即可
            'NotifyUrl' => $this->asyncUrl,
            'RedirectUrl' => $this->syncUrl,
            'Timestamp'    => time(), // 增加时间戳参数
        ];
            
        $param['signature'] = $this->md5($param, $this->config['key']);

        $url = trim($this->config['url'], "/");

        $pay = new \Kernel\Plugin\Entity\Pay();
        $pay->setTimeout(300);

        $this->plugin->log("下单金额：{$this->amount}");

        try {
            $request = Http::make()->post(trim($this->config['url'], "/") . '/CreateOrder', [
            'headers' => [
                'Content-Type' => 'application/json'
            ],
                'body' => json_encode($param),
            ]);
        } catch (\Throwable $e) {
            $this->plugin->log("url：{$this->config['url']} TokenPay请求出错：" . $e->getMessage(), true);
            throw new JSONException("支付接口出错，请查看插件日志");
        }

        $contents = $request->getBody()->getContents();
        $json = (array)json_decode((string)$contents, true);
        if (!isset($json['success']) || !$json['success']) {
            throw new JSONException("支付网关异常". $json['message']);
        }

        $pay->setPayUrl($json['data']);
        $pay->setRenderMode(\Kernel\Plugin\Const\Pay::RENDER_JUMP);
        $pay->setOption($param);

        return $pay;
    }


    /**
     * @return Response
     * @throws JSONException
     * @throws \ReflectionException
     */
    public function async(): Response
    {
        $data = (array)(empty($this->request->post()) ? $this->request->get() : $this->request->post());

        if (!isset($data['sign']) || !$this->verification($data)) {
            throw new JSONException("签名错误");
        }

        $this->plugin->log("订单金额: {$data['Amount']}，订单应支付法币金额：{$data['ActualAmount']}，实际支付金额：{$data['PayAmount']}");

        if ($this->config['typename'] != $data['Currency']) {
            throw new JSONException("支付类型错误");
        }

        if ($this->order->trade_no != $data['OutOrderId']) {
            throw new JSONException("订单号错误");
        }

        if ($this->amount != $data['Amount']) {
            throw new JSONException("金额不正确");
        }

        if ($data['Status'] == "Expired") {
            throw new JSONException("订单超时");
        }
        if ($data['Status'] == "Pending") {
            throw new JSONException("订单挂住中");
        }
        if ($data['Status'] == "Paid") {
            throw new JSONException("订单已支付");
            $this->successful();
            return $this->response->raw("success");
        }

        $this->successful();
        return $this->response->raw("success");
    }


    /**
     * @param array $data
     * @return bool
     */
    private function verification(array $data): bool
    {
        $sign = $data['sign'];
        unset($data['sign']);
        unset($data['sign_type']);

        if ($sign == $this->md5($data, $this->config['key'])) {
            return true;
        }

        return false;
    }


    /**
     * @param array $data
     * @param string $key
     * @return string
     */
    private function md5(array $data, string $key): string
    {
        ksort($data);
        $sign = '';
        foreach ($data as $k => $v) {
            $sign .= $k . '=' . $v . '&';
        }
        $sign = trim($sign, '&');

        return md5($sign . $key);
    }

    /**
     * @param array $param
     * @return string
     */
    private function getStr(array $param): string
    {
        ksort($param);
        $str = '';
        foreach ($param as $k => $v) {
            if (empty($v) || is_array($v) || $k == 'sign' || $k == 'sign_type') {
                continue;
            }
            $str .= '&' . $k . '=' . $v;
        }
        return substr($str, 1);
    }
}
