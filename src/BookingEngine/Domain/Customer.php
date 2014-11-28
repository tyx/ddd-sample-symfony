<?php

namespace Afsy\BookingEngine\Domain;

class Customer
{
    private $id;

    private $emailAddress;

    public function __construct($id, $emailAddress)
    {
        $this->id = $id;
        $this->emailAddress = $emailAddress;
    }

    public function getId()
    {
        return $this->id;
    }
}
