<?php

namespace Afsy\BookingEngine\Domain\Payment;

interface PaymentResponse
{
    public function isSuccessful();

    public function failed();
}
