<?php

namespace Nyehandel\Omnipay\Swish\Message;

class PurchaseRequest extends AbstractRequest
{
    protected function getHttpMethod()
    {
        return 'PUT';
    }

    protected function getEndpoint()
    {
        $instructionUUID = $this->generateRandString();

        return parent::getEndpoint().'/paymentrequests/' . $instructionUUID;
    }

    /*
     *  This function generates a UUID for swish according to their specification, which is: ^[0-9A-F]{32}$
     */
    private function generateRandString(): string
    {

        $randString = '';
        while (strlen($randString) < 32) {
            // generate a character between 0-9 a-f
            $character = mt_rand(0,15);
            if ($character > 9) $character += 7;
            $randString .= chr($character + 48);
        }

        return $randString;
    }

}
