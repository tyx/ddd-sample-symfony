<?php

namespace Afsy\Common\Domain\Payment;

class ObfuscatedNumber
{
    private $value;

    public function __construct($number, $nbOfLastCardNumberDigitsToKeep = 4)
    {
        $partToKeep = substr(
            $number,
            -$nbOfLastCardNumberDigitsToKeep,
            $nbOfLastCardNumberDigitsToKeep
        );

        $this->value = str_pad($partToKeep, mb_strlen($number), 'X', STR_PAD_LEFT);
    }

    public function __toString()
    {
        return $this->value;
    }
}
