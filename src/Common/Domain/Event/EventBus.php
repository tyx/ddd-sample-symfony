<?php

namespace Afsy\Common\Domain\Event;

interface EventBus
{
    public function publish(DomainEvent $event);
}
