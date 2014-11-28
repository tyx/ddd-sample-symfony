<?php

namespace Afsy\BookingEngine\App;

use Afsy\Common\Domain\Price;
use Afsy\Common\Domain\Payment\CreditCard;
use Afsy\BookingEngine\Domain\Booking;
use Afsy\BookingEngine\Domain\BookingRepository;
use Afsy\BookingEngine\Domain\Customer\CustomerRepository;
use Afsy\BookingEngine\Domain\Payment\PaymentGateway;
use Afsy\BookingEngine\Domain\Payment\PaymentWithCreditCard;
use Afsy\BookingEngine\Domain\Deal\DealRepository;

class BookingService
{
    private $bookingQueryService;

    private $paymentGateway;

    private $bookingRepository;

    private $dealRepository;

    private $customerRepository;

    public function __construct(
        BookingQueryService $bookingQueryService,
        BookingRepository $bookingRepository,
        DealRepository $dealRepository,
        CustomerRepository $customerRepository,
        PaymentGateway $paymentGateway
    )
    {
        $this->bookingQueryService = $bookingQueryService;
        $this->bookingRepository = $bookingRepository;
        $this->dealRepository = $dealRepository;
        $this->customerRepository = $customerRepository;
        $this->paymentGateway = $paymentGateway;
    }

    public function bookDeal(BookDealCommand $command)
    {
        $deal = $this->findDeal($command->getDealId());
        $customer = $this->findCustomer($command->getCustomerId());

        $booking = new Booking($deal, $customer, new Price(100, 'EUR'));

        $this->bookingRepository->save($booking);
    }

    public function payBooking(PayBookingCommand $command)
    {
        // Use repository to verify booking belonging. Instead of getting booking and verify if booking belong to customer
        $booking = $this->bookingQueryService->bookingOfCustomer($command->getBookingId(), $command->getCustomerId());

        $booking->pay(
            $this->paymentGateway,
            new PaymentWithCreditCard(
                new CreditCard(
                    $command->creditCardHolder,
                    $command->creditCardNumber,
                    $command->creditCardCvc,
                    $command->creditCardExpirationDate
                )
            )
        );

        $this->bookingRepository->save($booking);
    }

    private function findDeal($dealId)
    {
        $deal = $this->dealRepository->find($dealId);

        if (null === $deal) {
            throw new DealNotFoundException(sprintf('No deal found with id #%s', $dealId));
        }

        return $deal;
    }

    private function findCustomer($customerId)
    {
        $customer = $this->customerRepository->find($customerId);

        if (null === $customer) {
            throw new CustomerNotFoundException(sprintf('No customer found with id #%s', $customerId));
        }

        return $customer;
    }
}
