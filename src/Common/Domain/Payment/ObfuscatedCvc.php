<?php

namespace Afsy\Common\Domain\Payment;

class ObfuscatedCvc
{
    private $value;

    public function __construct($cvc)
    {
        $length = mb_strlen($cvc) > 5 ? 5 : mb_strlen($cvc);
        $this->value = str_pad('', $length, 'X');
    }

    public function __toString()
    {
        return $this->value;
    }
}
