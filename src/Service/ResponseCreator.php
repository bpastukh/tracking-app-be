<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

interface ResponseCreator
{
    public function create(array $payload = null, int $statusCode = Response::HTTP_OK): JsonResponse;
}
