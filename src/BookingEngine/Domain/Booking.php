<?php

namespace Afsy\BookingEngine\Domain;

use Afsy\Common\Domain\Price;
use Afsy\Common\Domain\Payment\ObfuscatedCreditCard;
use Afsy\Common\Domain\Event\AggregateRoot;
use Afsy\BookingEngine\Domain\Payment\BookingCreditCard;
use Afsy\BookingEngine\Domain\Payment\PaymentGateway;
use Afsy\BookingEngine\Domain\Payment\PaymentResponse;
use Afsy\BookingEngine\Domain\Payment\PaymentWithCreditCard;

class Booking extends AggregateRoot
{
    private $id;

    private $deal;

    private $customer;

    private $status;

    private $price;

    private $currency;

    private $confirmedAt;

    private $createdAt;

    private $creditCard;

    /**
     * Yes we can ! Never used by doctrine.
     */
    public function __construct(Deal $deal, Customer $customer, Price $price)
    {
        $this->deal = $deal;
        $this->customer = $customer;
        $this->price = $price->getAmount();
        $this->currency = $price->getCurrency();
        $this->setStatus(BookingStatus::PENDING);
        $this->apply(
            new DealBooked($this->deal->getId(), $this->customer->getId())
        );
        $this->createdAt = new \DateTime('UTC');
    }

    public function pay(PaymentGateway $paymentGateway, PaymentWithCreditCard $paymentType)
    {
        $this->guardStillAvailableForPayment();

        $this->setStatus(BookingStatus::WAIT_FOR_PAYMENT);

        $paymentResponse = $paymentGateway->requestPayment(
            $this->id,
            $paymentType,
            new Price($this->price, $this->currency),
            $this->customer,
            'booking#'.$this->id
        );

        $this->reviewPaymentResponse($paymentResponse);

        // Want to track basic information about the creditCard
        $this->setBookingCreditCard(new BookingCreditCard($this, ObfuscatedCreditCard::fromClearCreditCard($paymentType->getCreditCard())));
    }

    private function guardStillAvailableForPayment()
    {
        if ($this->isConfirmed()) {
            throw new InvalidBookingStatusException(
                sprintf('Booking #%s already confirmed', $this->id)
            );
        }
    }

    private function confirm()
    {
        $this->setStatus(BookingStatus::CONFIRMED);
        $this->confirmedAt = new \DateTime('UTC');
        $this->apply(
            new BookingConfirmed($this->id, $this->deal->getId(), $this->customer->getId())
        );
    }

    private function refuseForUnauthorization()
    {
        $this->setStatus(BookingStatus::REFUSED);
        $this->apply(
            new BookingRefused($this->id)
        );
    }

    private function reviewPaymentResponse(PaymentResponse $paymentResponse)
    {
        if ($paymentResponse->isSuccessful()) {
            $this->confirm();
        } elseif ($paymentResponse->failed()) {
            $this->refuseForUnauthorization();
        } else {
            $this->error();
        }
    }

    private function isConfirmed()
    {
        return $this->status === BookingStatus::CONFIRMED;
    }

    private function setStatus($status)
    {
        $this->status = (string) new BookingStatus($status);
    }

    private function setBookingCreditCard(BookingCreditCard $bookingCreditCard)
    {
        $this->creditCard = new \Doctrine\Common\Collections\ArrayCollection();
        $this->creditCard[0] = $bookingCreditCard;
    }
}
