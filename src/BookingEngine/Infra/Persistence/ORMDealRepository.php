<?php

namespace Afsy\BookingEngine\Infra\Persistence;

use Doctrine\ORM\EntityManager;

use Afsy\BookingEngine\Domain\Deal;
use Afsy\BookingEngine\Domain\Deal\DealRepository;

class ORMDealRepository implements DealRepository
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

    public function find($dealId)
    {
        return $this->internalRepository->find($dealId);
    }
}
