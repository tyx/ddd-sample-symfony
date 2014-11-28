<?php

namespace Afsy\BookingEngine\Domain\Deal;

interface DealRepository
{
    public function find($dealId);
}
