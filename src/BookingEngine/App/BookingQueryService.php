<?php

namespace Afsy\BookingEngine\App;

use Afsy\BookingEngine\Domain\BookingRepository;

class BookingQueryService
{
    private $bookingRepository;

    public function __construct(BookingRepository $bookingRepository)
    {
        $this->bookingRepository = $bookingRepository;
    }

    public function find($bookingId)
    {
        $booking = $this->bookingRepository->find($bookingId);
        $this->guardValidBooking($booking, $bookingId);

        return $booking;
    }

    public function bookingOfCustomer($bookingId, $customerId)
    {
        $booking = $this->bookingRepository->bookingOfCustomer($bookingId, $customerId);
        $this->guardValidBooking($booking, $bookingId);

        return $booking;
    }

    private function guardValidBooking($booking, $bookingId)
    {
        if (null === $booking) {
            throw new BookingNotFoundException(sprintf('Cannot find booking#%s', $bookingId));
        }
    }
}
