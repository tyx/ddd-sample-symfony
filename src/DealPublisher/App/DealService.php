<?php

namespace Afsy\DealPublisher\App;

use Afsy\DealPublisher\Domain\DealRepository;

class DealService
{
    public function __construct(DealRepository $dealRepository)
    {
        $this->dealRepository = $dealRepository;
    }

    public function saleDeal(SaleDealCommand $command)
    {
        $deal = $this->dealRepository->find($command->getDealId());

        $deal->sale();

        $this->dealRepository->save($deal);
    }
}
