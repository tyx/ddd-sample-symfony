<?php

namespace Afsy\Common\Domain\Event;

class EventName
{
    private $value;

    public function __construct(DomainEvent $event)
    {
        $this->value = $this->convertToDotName(get_class($event));
    }

    public function __toString()
    {
        return $this->value;
    }

    /**
     * Will transform "Afsy\BookingEngine\Domain\BookingConfirmed" to "booking.confirmed"
     */
    private function convertToDotName($fullClass)
    {
        $parts = explode("\\", $fullClass);

        $class = end($parts);

        $name = preg_replace('/(?<=[a-zA-Z])([A-Z])(?=[a-zA-Z])/', '.$1', $class);

        return strtolower($name);
    }
}
