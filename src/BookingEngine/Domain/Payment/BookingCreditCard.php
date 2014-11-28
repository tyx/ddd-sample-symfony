<?php

namespace Afsy\BookingEngine\Domain\Payment;

use Afsy\BookingEngine\Domain\Booking;
use Afsy\Common\Domain\Payment\ObfuscatedCreditCard;

class BookingCreditCard
{
    private $id;

    private $booking;

    private $holder;

    private $number;

    private $cvc;

    private $expirationDate;

    private $type;

    public function __construct(Booking $booking, ObfuscatedCreditCard $creditCard)
    {
        $this->booking = $booking;
        $this->holder = $creditCard->getHolder();
        $this->number = $creditCard->getNumber();
        $this->cvc = $creditCard->getCvc();
        $this->expirationDate = $creditCard->getExpirationDate();
    }
}
