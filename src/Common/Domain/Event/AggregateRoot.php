<?php

namespace Afsy\Common\Domain\Event;

abstract class AggregateRoot
{
    private $events = array();

    public function pullDomainEvents()
    {
        $events = $this->events;
        $this->events = array();

        return $events;
    }

    protected function apply(DomainEvent $event)
    {
        $this->events[] = $event;
    }
}
