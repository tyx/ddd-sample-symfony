<?php

namespace Afsy\BookingEngine\Infra\Payment;

use Symfony\Component\HttpFoundation\RequestStack;

use Afsy\Common\Domain\Price;
use Afsy\BookingEngine\Domain\Payment\PaymentGateway;
use Afsy\BookingEngine\Domain\Payment\PaymentWithCreditCard;
use Afsy\BookingEngine\Domain\Customer;

class StubPaymentGateway implements PaymentGateway
{
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function requestPayment($bookingId, PaymentWithCreditCard $paymentType, Price $price, Customer $customer, $paymentDescription)
    {
        $currentRequest = $this->requestStack->getCurrentRequest();
        $result = $currentRequest->headers->get('X-PAYMENT_RESULT');

        return new StubPaymentResponse(
            filter_var($result, FILTER_VALIDATE_BOOLEAN)
        );
    }
}
