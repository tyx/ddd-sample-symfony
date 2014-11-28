<?php

namespace Afsy\DealPublisher\Infra\Persistence;

use Doctrine\ORM\EntityManager;

use Afsy\DealPublisher\Domain\Deal;
use Afsy\DealPublisher\Domain\DealRepository;

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

    public function save(Deal $deal)
    {
        $this->em->persist($deal);
        $this->em->flush();
    }
}
