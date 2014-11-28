<?php

namespace Afsy\BookingEngine\Infra\Payment;

use Afsy\BookingEngine\Domain\Payment\PaymentResponse;

class StubPaymentResponse implements PaymentResponse
{
    private $success;

    public function __construct($success)
    {
        $this->success = $success;
    }

    public function isSuccessful()
    {
        return true === $this->success;
    }

    public function failed()
    {
        return false === $this->success;
    }
}
