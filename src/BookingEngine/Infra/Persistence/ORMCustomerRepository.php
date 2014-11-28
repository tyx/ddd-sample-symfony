<?php

namespace Afsy\BookingEngine\Infra\Persistence;

use Doctrine\ORM\EntityManager;

use Afsy\BookingEngine\Domain\Customer;
use Afsy\BookingEngine\Domain\Customer\CustomerRepository;

class ORMCustomerRepository implements CustomerRepository
{
    private $em;

    private $className;

    private $internalRepository;

    public function __construct(EntityManager $em, $className)
    {
        $this->em = $em;
        $this->className = $className;
        $this->internalRepository = $this->em->getRepository($className);
    }

    public function find($customerId)
    {
        return $this->internalRepository->find($customerId);
    }
}
