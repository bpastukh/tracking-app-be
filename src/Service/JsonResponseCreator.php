<?php

declare(strict_types=1);

namespace App\Service;

use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class JsonResponseCreator implements ResponseCreator
{
    private SerializerInterface $serializer;

    public function __construct(
        SerializerInterface $serializer
    ) {
        $this->serializer = $serializer;
    }

    private function createResponse(array $response, int $statusCode = Response::HTTP_OK): JsonResponse
    {
        $context = new SerializationContext();
        $context->setSerializeNull(true);
        $serialized = $this->serializer->serialize($response, 'json', $context);

        return new JsonResponse($serialized, $statusCode, [], true);
    }

    public function create(array $payload = null, int $statusCode = Response::HTTP_OK): JsonResponse
    {
        $response = [];
        $response['code'] = Response::HTTP_OK;
        $response['payload'] = $payload;

        return $this->createResponse($response, $statusCode);
    }
}
