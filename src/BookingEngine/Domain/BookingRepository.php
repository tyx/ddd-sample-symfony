<?php

namespace Afsy\BookingEngine\Domain;

interface BookingRepository
{
    public function find($bookingId);

    public function bookingOfCustomer($bookingId, $customerId);
}
