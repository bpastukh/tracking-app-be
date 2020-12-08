<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\ResponseCreator;
use App\UserModule\Application\RegisterUserService;
use Assert\InvalidArgumentException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class SecurityController
{
    /**
     * @Route("/login", methods={"POST"})
     */
    public function login(ResponseCreator $responseCreator): JsonResponse
    {
        return $responseCreator->createOK();
    }

    /**
     * @Route("/register", methods={"POST"})
     */
    public function register(
        ResponseCreator $responseCreator,
        Request $request,
        RegisterUserService $service
    ): JsonResponse {
        try {
            $email = $request->request->get('email');
            $password = $request->request->get('password');
            $service->register($email, $password);
        } catch (InvalidArgumentException $exception) {
            return $responseCreator->createBadRequest(['message' => $exception->getMessage()]);
        }

        return $responseCreator->createResponse([], Response::HTTP_CREATED);
    }
}
