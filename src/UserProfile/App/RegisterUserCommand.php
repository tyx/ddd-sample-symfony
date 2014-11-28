<?php

namespace Afsy\UserProfile\App;

class RegisterUserCommand
{
    public $firstName;

    public $lastName;

    public $emailAddress;

    public $password;

    public function __construct($firstName, $lastName, $emailAddress, $password)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->emailAddress = $emailAddress;
        $this->password = $password;
    }
}
