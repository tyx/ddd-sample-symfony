<?php

namespace Afsy\BookingEngine\Infra;

use JMS\Serializer\Serializer;

use Afsy\BookingEngine\Domain\Customer;

class CustomerTransformer
{
    private $serializer;

    public function __construct(Serializer $serializer)
    {
        $this->serializer = $serializer;
    }

    public function toCustomerFromUserRepresentation($representation)
    {
        $userRepresentation = $this->serializer->deserialize($representation, 'Afsy\UserProfile\App\Representation\UserRepresentation', 'json');

        return new Customer($userRepresentation->getId(), $userRepresentation->getEmailAddress());
    }
}
