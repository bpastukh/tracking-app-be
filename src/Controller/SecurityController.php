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
        return $responseCreator->create();
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
            if (is_null($email) || is_null($password)) {
                throw new InvalidArgumentException('Bad request', Response::HTTP_BAD_REQUEST);
            }
            $service->register($email, $password);
        } catch (InvalidArgumentException $exception) {
            return $responseCreator->create(['message' => $exception->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        return $responseCreator->create([], Response::HTTP_CREATED);
    }
}
