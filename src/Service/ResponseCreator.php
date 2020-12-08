<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

interface ResponseCreator
{
    public function createOK(array $payload = null): JsonResponse;

    public function createBadRequest(array $payload = null): JsonResponse;

    public function createResponse(array $response, int $statusCode = Response::HTTP_OK): JsonResponse;
}
