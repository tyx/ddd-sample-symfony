<?php

namespace Afsy\DealPublisher\Domain;

class Deal
{
    private $id;

    private $quantity;

    private $price;

    private $currency;

    private $startAt;

    private $endAt;

    public function sale()
    {
        if ($this->quantity <= 0) {
            throw new \LogicException(sprintf('Cannot sale deal #%s. No more quantity available', $this->id));
        }

        $this->quantity--;
    }
    // Imagine many and many methods to calculate price, etc...
}
