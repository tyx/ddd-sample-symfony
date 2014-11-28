<?php

namespace Afsy\Common\Domain\Payment;

class ObfuscatedCreditCard extends CreditCard
{
    public static function fromClearCreditCard(CreditCard $creditCard)
    {
        return new ObfuscatedCreditCard(
            $creditCard->getHolder(),
            (string) new ObfuscatedNumber($creditCard->getNumber()),
            (string) new ObfuscatedCvc($creditCard->getCvc()),
            $creditCard->getExpirationDate(),
            $creditCard->getType()
        );
    }

    protected function setNumber($number)
    {
        if (ctype_digit($number)) {
            throw new \InvalidArgumentException('Obfuscated credit card should not have clear number');
        }

        $this->number = $number;
    }

    protected function setCvc($cvc)
    {
        if (ctype_digit($cvc)) {
            throw new \InvalidArgumentException('Obfuscated credit card should not have clear cvc');
        }

        $this->cvc = $cvc;
    }
}
