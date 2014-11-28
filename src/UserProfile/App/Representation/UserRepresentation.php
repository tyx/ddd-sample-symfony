<?php

namespace Afsy\UserProfile\App\Representation;

use Afsy\UserProfile\Domain\User;

class UserRepresentation
{
    private $id;

    private $emailAddress;

    public function __construct(User $user)
    {
        $this->id = $user->getId();
        $this->emailAddress = $user->getIdentity()->getEmailAddress();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getEmailAddress()
    {
        return $this->emailAddress;
    }
}
