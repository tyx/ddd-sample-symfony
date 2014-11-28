<?php

namespace Afsy\Common\Infra;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;

use Afsy\Common\Domain\Event\EventBus;
use Afsy\Common\Domain\Event\DomainEvent;
use Afsy\Common\Domain\Event\EventName;

class SymfonyEventBus implements EventBus
{
    private $eventDispatcher;

    public function __construct(EventDispatcherInterface $eventDispatcher, $logger)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->logger = $logger;
    }

    public function publish(DomainEvent $event)
    {
        $this->logEvent($event);
        $eventName = (string) new EventName($event);
        $this->eventDispatcher->dispatch($eventName, $event);
    }

    private function logEvent($event)
    {
        $refEvent = new \ReflectionClass($event);
        $refEventProperties = $refEvent->getProperties();
        $logContext = array();

        foreach ($refEventProperties as $property) {
            $propertyName = $property->getName();
            $getter = 'get'.ucfirst($propertyName);
            $logContext[$propertyName] = $event->{$getter}();
        }

        $this->logger->info($refEvent->getName(), $logContext);
    }
}
