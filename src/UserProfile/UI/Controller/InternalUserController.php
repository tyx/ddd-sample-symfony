<?php

namespace Afsy\UserProfile\UI\Controller;

use JMS\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

use Afsy\UserProfile\App\UserQueryService;
use Afsy\UserProfile\App\UserNotFoundException;
use Afsy\UserProfile\App\Representation\UserRepresentation;

class InternalUserController
{
    private $userQueryService;

    private $serializer;

    public function __construct(UserQueryService $userQueryService, Serializer $serializer)
    {
        $this->userQueryService = $userQueryService;
        $this->serializer = $serializer;
    }

    public function getAction(Request $request, $userId)
    {
        try {
            $userRepresentation = new UserRepresentation($this->userQueryService->user($userId));

            return new Response(
                $this->serializer->serialize($userRepresentation, 'json'),
                200,
                array(
                    'Content-Type' => 'application/json'
                )
            );
        } catch (UserNotFoundException $exception) {
            throw new HttpException(404, $exception->getMessage(), $exception);
        }
    }
}
