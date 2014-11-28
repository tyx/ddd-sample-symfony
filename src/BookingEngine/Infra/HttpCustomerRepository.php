<?php

namespace Afsy\BookingEngine\Infra;

use Guzzle\Http\ClientInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

use Afsy\BookingEngine\Domain\Customer\CustomerRepository;

class HttpCustomerRepository implements CustomerRepository
{
    const ROUTE_NAME = 'user_profile_internal_get_user';

    private $httpClient;

    private $router;

    private $customerTransformer;

    public function __construct(ClientInterface $httpClient, UrlGeneratorInterface $router, CustomerTransformer $customerTransformer)
    {
        $this->httpClient = $httpClient;
        $this->router = $router;
        $this->customerTransformer = $customerTransformer;
    }

    public function find($customerId)
    {
        $url = $this->router->generate(
            self::ROUTE_NAME,
            array(
                'userId' => $customerId
            )
        );

        try {
            return $this->customerTransformer->toCustomerFromUserRepresentation(
                $this->httpClient->get($url)->send()->getBody(true)
            );
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            if (404 === $e->getResponse()->getStatusCode()) {
                return null;
            }

            throw $e;
        }
    }
}
