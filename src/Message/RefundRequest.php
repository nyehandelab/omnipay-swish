<?php

namespace Nyehandel\Omnipay\Swish\Message;

class RefundRequest extends AbstractRequest
{
    public function getData()
    {
        $this->validate(
            'originalPaymentReference',
            'notifyUrl',
            'payerAlias',
            'amount',
            'currency',
        );

        return [
            'originalPaymentReference' => $this->getOriginalPaymentReference(),
            'callbackUrl' => $this->getNotifyUrl(),
            'payerAlias' => $this->getPayerAlias(),
            'amount' => $this->getAmount(),
            'currency' => $this->getCurrency(),
            'payerPaymentReference' => $this->getPayerPaymentReference(),
            'message' => $this->getMessage(),
        ];
    }

    public function getOriginalPaymentReference()
    {
        return $this->getParameter('originalPaymentReference');
    }

    public function setOriginalPaymentReference($value)
    {
        return $this->setParameter('originalPaymentReference', $value);
    }

    public function getPayerPaymentReference()
    {
        return $this->getParameter('payerPaymentReference');
    }

    public function setPayerPaymentReference($value)
    {
        return $this->setParameter('payerPaymentReference', $value);
    }

    protected function getHttpMethod()
    {
        return 'PUT';
    }

    protected function getEndpoint()
    {
        $instructionUUID = $this->generateRandString();

        return parent::getEndpoint().'/refunds/' . $instructionUUID;
    }
}
