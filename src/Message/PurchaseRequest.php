<?php

namespace Nyehandel\Omnipay\Swish\Message;

class PurchaseRequest extends AbstractRequest
{
    public function getData()
    {
        $this->validate('notifyUrl', 'amount', 'currency', 'payeeAlias');

        $data = [
            'payeeAlias' => $this->getPayeeAlias(),
            'payerAlias' => $this->getPayerAlias(),
            'amount' => $this->getAmount(),
            'currency' => $this->getCurrency(),
            'callbackUrl' => $this->getNotifyUrl(),
            'message' => $this->getMessage(),
            'payeePaymentReference' => $this->getPayeePaymentReference(),
        ];

        return $data;
    }

    public function setPayeeAlias($value)
    {
        return $this->setParameter('payeeAlias', $value);
    }

    public function getPayeeAlias()
    {
        return $this->getParameter('payeeAlias');
    }

    public function getPayeePaymentReference()
    {
        return $this->getParameter('payeePaymentReference');
    }

    public function setPayeePaymentReference($value)
    {
        return $this->setParameter('payeePaymentReference', $value);
    }

    protected function getHttpMethod()
    {
        return 'PUT';
    }

    protected function getEndpoint()
    {
        $instructionUUID = $this->generateRandString();

        return parent::getEndpoint().'/paymentrequests/' . $instructionUUID;
    }
}
