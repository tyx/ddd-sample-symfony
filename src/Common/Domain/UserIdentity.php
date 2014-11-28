<?php

namespace Afsy\Common\Domain;

class UserIdentity
{
    private $firstName;

    private $lastName;

    private $emailAddress;

    public function __construct($firstName, $lastName, $emailAddress)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->emailAddress = $emailAddress;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function getEmailAddress()
    {
        return $this->emailAddress;
    }
}
