<?php

namespace Afsy\DealPublisher\UI\Controller;

class InternalApiController
{
    private $dealService;

    private $serializer;

    public function __construct(DealService $dealQueryService, Serializer $serializer)
    {
        $this->dealQueryService = $dealQueryService;
        $this->serializer = $serializer;
    }

    public function getAction($dealId)
    {
        try {
            $dealDescription = $this->dealQueryService->find($dealId)->toDealDescription();

            return new JsonResponse(
                $this->serializer->serialize($dealDescription, 'json')
            );
        } catch (DealNotFoundException $exception) {
            throw new HttpException(404, $exception->getMessage(), $exception);
        }
    }
}
