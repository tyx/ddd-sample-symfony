<?php

namespace Afsy\UserProfile\Domain;

use Afsy\Common\Domain\Event\DomainEvent;

class UserFailedToAuthenticate implements DomainEvent
{
    public function __construct($userId)
    {
        $this->userId = $userId;
    }
}
