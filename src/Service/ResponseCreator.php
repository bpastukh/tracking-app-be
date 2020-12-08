<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Component\HttpFoundation\JsonResponse;

interface ResponseCreator
{
    public function createOK(array $payload = null): JsonResponse;

    public function createBadRequest(array $payload = null): JsonResponse;
}
