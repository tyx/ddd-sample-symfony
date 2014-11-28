<?php

namespace Afsy\BookingEngine\App;

class PayBookingCommand
{
    private $bookingId;

    private $customerId;

    public $creditCardHolder;

    public $creditCardNumber;

    public $creditCardCvc;

    public $creditCardExpirationDate;

    public function __construct($bookingId, $customerId)
    {
        $this->bookingId = $bookingId;
        $this->customerId = $customerId;
    }

    public function getBookingId()
    {
        return $this->bookingId;
    }

    public function getCustomerId()
    {
        return $this->customerId;
    }
}
