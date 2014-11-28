<?php

namespace Afsy\UserProfile\Domain;

use Afsy\Common\Domain\Event\DomainEvent;

class UserSuccessfullyAuthenticated implements DomainEvent
{
    public function __construct($userId)
    {
        $this->userId = $userId;
    }
}
