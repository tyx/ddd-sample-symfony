<?php

namespace Afsy\BookingEngine\Infra\Persistence;

use Doctrine\ORM\EntityManager;

use Afsy\Common\Domain\Event\EventBus;
use Afsy\BookingEngine\Domain\Booking;
use Afsy\BookingEngine\Domain\BookingRepository;

class ORMBookingRepository implements BookingRepository
{
    private $em;

    private $className;

    private $internalRepository;

    private $eventBus;

    public function __construct(EntityManager $em, $className, EventBus $eventBus)
    {
        $this->em = $em;
        $this->className = $className;
        $this->internalRepository = $this->em->getRepository($className);
        $this->eventBus = $eventBus;
    }

    public function find($bookingId)
    {
        return $this->internalRepository->find($bookingId);
    }

    public function bookingOfCustomer($bookingId, $customerId)
    {
        return $this->internalRepository
            ->createQueryBuilder('b')
            ->innerJoin('b.customer', 'c')
            ->andWhere('b.id = :bookingId')
            ->andWhere('c.id = :customerId')
            ->setParameters(array(
                'bookingId' => $bookingId,
                'customerId' => $customerId
            ))
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }


    public function save(Booking $booking)
    {
        try {
            $conn = $this->em->getConnection();
            $conn->beginTransaction();

            $this->em->persist($booking);
            $this->em->flush();

            foreach ($booking->pullDomainEvents() as $event) {
                $this->eventBus->publish($event);
            }

            $conn->commit();
        } catch (\Exception $e) {
            $conn->rollback();
            throw $e;
        }
    }
}
