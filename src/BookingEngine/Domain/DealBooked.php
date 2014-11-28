<?php

namespace Afsy\BookingEngine\Domain;

use Symfony\Component\EventDispatcher\Event;

use Afsy\Common\Domain\Event\DomainEvent;

class DealBooked extends Event implements DomainEvent
{
    private $bookingId;

    private $dealId;

    private $customerId;

    public function __construct($bookingId, $dealId, $customerId)
    {
        $this->bookingId = $bookingId;
        $this->dealId = $dealId;
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

    public function getDealId()
    {
        return $this->dealId;
    }
}
