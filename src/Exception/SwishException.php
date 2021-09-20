<?php

namespace Nyehandel\Omnipay\Swish\Exception;

use Nyehandel\Omnipay\Swish\Translator;

class SwishException extends \Exception
{
    public function __construct($swishCode, $code, $language = 'sv')
    {
        $translator = new Translator();
        $message = $translator->getErrorMessage($swishCode, $language);

        parent::__construct($message, $code);
    }
}
