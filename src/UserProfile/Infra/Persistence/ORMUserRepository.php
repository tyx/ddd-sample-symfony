<?php

namespace Afsy\UserProfile\Infra\Persistence;

use Doctrine\ORM\EntityManager;

use Afsy\UserProfile\Domain\User;
use Afsy\UserProfile\Domain\UserRepository;

class ORMUserRepository implements UserRepository
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

    public function find($userId)
    {
        return $this->internalRepository->find($userId);
    }

    public function save(User $user)
    {
        $this->em->persist($user);
        $this->em->flush();
    }
}
