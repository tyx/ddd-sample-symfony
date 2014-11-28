<?php

namespace Afsy\DealPublisher\App;

class SaleDealCommand
{
    private $dealId;

    public function __construct($dealId)
    {
        $this->dealId = $dealId;
    }

    public function getDealId()
    {
        return $this->dealId;
    }
}
