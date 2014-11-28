<?php

namespace Afsy\BookingEngine\Domain\Customer;

interface CustomerRepository
{
    public function find($customerId);
}
