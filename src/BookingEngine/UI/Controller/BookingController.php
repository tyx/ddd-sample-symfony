<?php

namespace Afsy\BookingEngine\UI\Controller;

use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;

use Afsy\Common\UI\FormErrorsRepresentation;
use Afsy\BookingEngine\App\BookingService;
use Afsy\BookingEngine\App\BookingQueryService;
use Afsy\BookingEngine\App\PayBookingCommand;
use Afsy\BookingEngine\UI\Form\PayBookingFormType;
use Afsy\BookingEngine\Domain\InvalidBookingStatusException;

class BookingController
{
    private $bookingService;

    private $securityContext;

    private $formFactory;

    private $bookingQueryService;

    public function __construct(BookingService $bookingService, BookingQueryService $bookingQueryService, SecurityContext $securityContext, FormFactory $formFactory)
    {
        $this->bookingService = $bookingService;
        $this->bookingQueryService = $bookingQueryService;
        $this->securityContext = $securityContext;
        $this->formFactory = $formFactory;
    }

    public function postBookingPayAction($bookingId, Request $request)
    {
        // $customerId = $this->securityContext->getToken()->getUser()->getId();
        $command = new PayBookingCommand($bookingId, 1);

        // Forms are really helpful to map request to our commands
        $form = $this->createForm(new PayBookingFormType, $command);
        $form->handleRequest($request);

        if (!$form->isValid()) {
            throw new HttpException(406, (string) new FormErrorsRepresentation($form->getErrors()));
        }

        try {
            // Send the message
            $this->bookingService->payBooking($command);

            return new JsonResponse(array('ok'));
        } catch (InvalidBookingStatusException $e) {
            throw new HttpException(406, $e->getMessage(), $e);
        } catch (BookingNotFoundException $e) {
            throw new HttpException(404, $e->getMessage(), $e);
        }
    }

    private function createForm($type, $data = null, array $options = array())
    {
        return $this->formFactory->create($type, $data, $options);
    }
}
