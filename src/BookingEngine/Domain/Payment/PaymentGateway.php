<?php

namespace Afsy\BookingEngine\Domain\Payment;

use Afsy\Common\Domain\Price;
use Afsy\BookingEngine\Domain\Customer;

interface PaymentGateway
{
    public function requestPayment($bookingId, PaymentWithCreditCard $paymentType, Price $price, Customer $customer, $paymentDescription);
}
