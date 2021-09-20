<?php

namespace Nyehandel\Omnipay\Swish\Message;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\CurlHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use Nyehandel\Omnipay\Swish\Exception\SwishException;
use GuzzleHttp\Exception\ClientException;

abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    protected $API_VERSION = 'v2';

    protected $liveEndpoint = 'https://cpc.getswish.net/swish-cpcapi/api';
    protected $testEndpoint = 'https://mss.cpc.getswish.net/swish-cpcapi/api';

    public function getCert()
    {
        return $this->getParameter('cert');
    }

    public function setCert($value)
    {
        return $this->setParameter('cert', $value);
    }

    public function getPrivateKey()
    {
        return $this->getParameter('privateKey');
    }

    public function setPrivateKey($value)
    {
        return $this->setParameter('privateKey', $value);
    }

    public function getCaCert()
    {
        return $this->getParameter('caCert');
    }

    public function setCaCert($value)
    {
        return $this->setParameter('caCert', $value);
    }

    public function getPayeePaymentReference()
    {
        return $this->getParameter('payeePaymentReference');
    }

    public function setPayeePaymentReference($value)
    {
        return $this->setParameter('payeePaymentReference', $value);
    }

    public function getPayerAlias()
    {
        return $this->getParameter('payerAlias');
    }

    public function setPayerAlias($value)
    {
        return $this->setParameter('payerAlias', $value);
    }

    public function getPayeeAlias()
    {
        return $this->getParameter('payeeAlias');
    }

    public function setMessage($value)
    {
        return $this->setParameter('message', $value);
    }

    public function getMessage()
    {
        return $this->getParameter('message');
    }

    public function setPayeeAlias($value)
    {
        return $this->setParameter('payeeAlias', $value);
    }

    protected function getHttpMethod()
    {
        return 'POST';
    }

    protected function getEndpoint()
    {
        $url = $this->getTestMode() ? $this->testEndpoint : $this->liveEndpoint;

        return $url . '/' . $this->API_VERSION;
    }

    public function getData()
    {
        $this->validate('notifyUrl', 'amount', 'currency', 'payeeAlias');

        $data = [

            'callbackUrl' => $this->getNotifyUrl(),
            'amount' => $this->getAmount(),
            'currency' => $this->getCurrency(),
            'payerAlias' => $this->getPayerAlias(),
            'payeeAlias' => $this->getPayeeAlias(),
            'message' => $this->getMessage(),
        ];

        return $data;
    }

    public function sendData($data)
    {
        $client = new Client(
            [
                'cert' => $this->getCert(),
                'verify' => $this->getCaCert(),
                'handler' => HandlerStack::create(new CurlHandler()),
            ]
        );
        $options = [
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
        ];
        $endpoint = $this->getEndpoint();

        if ($this->getHttpMethod() == 'GET') {
            $endpoint .= '?' . http_build_query($data);
        } elseif ($this->getHttpMethod() == 'PUT' || $this->getHttpMethod() == 'POST' ) {
            $options['json'] = $data;
        }

        try {
            $response = $client->request(
                $this->getHttpMethod(),
                $endpoint,
                $options
            );

            return $this->response = $this->createResponse($response);
        } catch (\Exception $e) {
            // Extract the swish error code from the error message string recieved
            $errorCodeKey = '"errorCode":"';
            $errorMessageSubstring = substr($e->getMessage(), strpos($e->getMessage(), $errorCodeKey));
            $swishErrorCode = substr($errorMessageSubstring, strlen($errorCodeKey), strpos($errorMessageSubstring, ',') - strlen($errorCodeKey) - 1);

            dd($e);
            throw new SwishException(
                $swishErrorCode,
                $e->getCode(),
            );
        }
    }

    protected function createResponse($response)
    {
        $data = $response->getBody(true);
        $data = json_decode($data, true);
        $statusCode = $response->getStatusCode();

        return $this->response = new PurchaseResponse($this, $response, $data, $statusCode);
    }
}
