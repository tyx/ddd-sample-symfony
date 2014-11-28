<?php

namespace Afsy\DealPublisher\Domain;

interface DealRepository
{
    public function find($dealId);

    public function save(Deal $deal);
}
