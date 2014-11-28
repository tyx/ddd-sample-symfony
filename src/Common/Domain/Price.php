<?php

namespace Afsy\Common\Domain;

class Price
{
    private $amount;

    private $currency;

    public function __construct($amout, $currency)
    {
        $this->amount = (float) $amout;
        $this->currency = $currency;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function getCurrency()
    {
        return $this->currency;
    }
}
