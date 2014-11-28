<?php

namespace Afsy\BookingEngine\Domain;

class BookingStatus
{
    const PENDING = 'pending';

    const CONFIRMED = 'confirmed';

    const REFUSED = 'refused';

    const ERROR = 'error';

    const WAIT_FOR_PAYMENT = 'wait_for_payment';

    public function __construct($status)
    {
        $this->status = $status;
        $this->guardValidStatus();
    }

    public function __toString()
    {
        return $this->status;
    }

    public function isConfirmed()
    {
        return self::CONFIRMED === $this->status;
    }

    private function guardValidStatus()
    {
        $availableStatus = array(
            self::PENDING,
            self::CONFIRMED,
            self::REFUSED,
            self::WAIT_FOR_PAYMENT
        );

        if (!in_array($this->status, $availableStatus)) {
            throw new \LogicException(
                sprintf('Booking status "%s" not a valid status. Should be one of them : %s', $this->status, implode(',', $availableStatus))
            );
        }
    }
}
