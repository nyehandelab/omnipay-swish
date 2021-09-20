<?php

namespace Nyehandel\Omnipay\Swish\Message;

class FetchTransactionRequest extends AbstractRequest
{
    protected $API_VERSION = 'v1';

    public function getData()
    {
        $this->validate('transactionReference');

        return [];
    }

    protected function getHttpMethod()
    {
        return 'GET';
    }

    public function getEndpoint()
    {
        return parent::getEndpoint().'/paymentrequests/'.$this->getTransactionReference();
    }
}
