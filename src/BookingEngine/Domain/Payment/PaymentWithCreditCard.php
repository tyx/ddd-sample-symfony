<?php

namespace Afsy\BookingEngine\Domain\Payment;

use Afsy\Common\Domain\Payment\CreditCard;

class PaymentWithCreditCard
{
    private $creditCard;

    public function __construct(CreditCard $creditCard)
    {
        $this->creditCard = $creditCard;
    }

    public function getCreditCard()
    {
        return $this->creditCard;
    }
}
