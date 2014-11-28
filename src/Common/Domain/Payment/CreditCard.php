<?php

namespace Afsy\Common\Domain\Payment;

class CreditCard
{
    protected $holder;

    protected $number;

    protected $cvc;

    protected $expirationDate;

    protected $type;

    public function __construct($holder, $number, $cvc, $expirationDate, $type = null)
    {
        $this->holder = $holder;
        $this->setNumber($number);
        $this->setCvc($cvc);
        $this->expirationDate = $this->buildExpirationDate($expirationDate);

        // if (null === $type) {
        //     $typeGuesser = new CreditCardTypeGuesser;
        //     $this->type = $typeGuesser->guessFromCardNumber($this->number);
        // }
    }

    public function getHolder()
    {
        return $this->holder;
    }

    public function getNumber()
    {
        return $this->number;
    }

    public function getCvc()
    {
        return $this->cvc;
    }

    public function getExpirationDate()
    {
        return $this->expirationDate;
    }

    public function getType()
    {
        return $this->type;
    }

    protected function setCvc($cvc)
    {
        if (!preg_match('/^[0-9]{1,5}$/', $cvc)) {
            throw new InvalidCreditCardException(sprintf('Invalid credit card cvc : %s', $cvc), 'cvc');
        }

        $this->cvc = $cvc;
    }

    protected function setNumber($number)
    {
        $value = (string) $number;

        if (!ctype_digit($value)) {
            throw new InvalidCreditCardException(sprintf('Invalid credit card number : %s', $number), 'number');
        }

        $checkSum = 0;
        $length = strlen($value);

        if ($length !== 16) {
            throw new InvalidCreditCardException(sprintf('Invalid credit card number : %s', $number), 'number');
        }

        for ($i = $length - 1; $i >= 0; $i -= 2) {
            $checkSum += $value{$i};
        }
        for ($i = $length - 2; $i >= 0; $i -= 2) {
            $checkSum += array_sum(str_split($value{$i} * 2));
        }

        if (0 === $checkSum || 0 !== $checkSum % 10) {
            throw new InvalidCreditCardException(sprintf('Invalid credit card number : %s', $number), 'number');
        }

        $this->number = $number;
    }

    protected function buildExpirationDate($date)
    {
        try {
            if (is_string($date)) {
                if (1 === preg_match('/^[0-9]{4}-(0[1-9]|1[0-2])$/', $date)) {
                    // For format 'XXXX-XX' we add 01 to avoid weird behavior as described in https://github.com/rezzza/api.vlr/pull/370
                    $date = sprintf('%s-01', $date);
                }

                $date = new \DateTime($date);
            }

            $date->modify('first day of this month 00:00:00');

            if ($date < new \DateTime('first day of this month 00:00:00')) {
                throw new ExpiredCreditCardException();
            }

            return $date;
        } catch (ExpiredCreditCardException $e) {
            throw new InvalidCreditCardException('credit_card.expiration_date.too_low', null, $e);
        } catch (\Exception $e) {
            throw new InvalidCreditCardException('credit_card.expiration_date.invalid', null, $e);
        }
    }
}
