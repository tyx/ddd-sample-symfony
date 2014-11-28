<?php

namespace Afsy\DealPublisher\Domain;

use Afsy\BookingEngine\Domain\BookingConfirmed;
use Afsy\DealPublisher\App\DealService;
use Afsy\DealPublisher\App\SaleDealCommand;

class BookingConfirmedListener
{
    private $dealService;

    public function __construct(DealService $dealService)
    {
        $this->dealService = $dealService;
    }

    public function onBookingConfirmed(BookingConfirmed $event)
    {
        $this->dealService->saleDeal(new SaleDealCommand($event->getDealId()));
    }
}
