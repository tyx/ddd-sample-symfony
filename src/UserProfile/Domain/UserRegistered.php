<?php

namespace Afsy\UserProfile\Domain;

use Afsy\Common\Domain\Event\DomainEvent;

class UserRegistered implements DomainEvent
{
    public function __construct($userId)
    {
        $this->userId = $userId;
    }
}
