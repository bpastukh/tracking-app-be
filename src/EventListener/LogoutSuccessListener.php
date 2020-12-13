<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Service\ResponseCreator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Logout\LogoutSuccessHandlerInterface;

final class LogoutSuccessListener implements LogoutSuccessHandlerInterface
{
    private ResponseCreator $responseCreator;

    public function __construct(ResponseCreator $responseCreator)
    {
        $this->responseCreator = $responseCreator;
    }

    public function onLogoutSuccess(Request $request): JsonResponse
    {
        return $this->responseCreator->create();
    }
}
