<?php

namespace Afsy\BookingEngine\App;

class BookDealCommand
{
    private $dealId;

    private $customerId;

    public function __construct($dealId, $customerId)
    {
        $this->dealId = $dealId;
        $this->customerId = $customerId;
    }

    public function getDealId()
    {
        return $this->dealId;
    }

    public function getCustomerId()
    {
        return $this->customerId;
    }
}
