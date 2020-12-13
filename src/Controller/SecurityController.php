<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\ResponseCreator;
use App\UserModule\Application\RegisterUserService;
use Assert\InvalidArgumentException;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class SecurityController
{
    /**
     * @Route("/login", methods={"POST"})
     * @SWG\Response(
     *     response=200,
     *     description="Logs in and set's cookie for current user"
     *     )
     * )
     * @SWG\Response(
     *     response=401,
     *     description="Auth failed"
     *     )
     * )
     * @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="JSON Payload",
     *          required=true,
     *          format="application/json",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(property="email", type="string", example="johndoe@gmail.com"),
     *              @SWG\Property(property="password", type="string", example="qwerty"),
     *          )
     *
     *      ),
     */
    public function login(ResponseCreator $responseCreator): JsonResponse
    {
        return $responseCreator->create();
    }

    /**
     * @Route("/register", methods={"POST"})
     * @SWG\Response(
     *     response=201,
     *     description="Register new user"
     *     )
     * )
     * @SWG\Response(
     *     response=400,
     *     description="Bad request"
     *     )
     * )
     * @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="JSON Payload",
     *          required=true,
     *          format="application/json",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(property="email", type="string", example="johndoe@gmail.com"),
     *              @SWG\Property(property="password", type="string", example="qwerty"),
     *          )
     *
     *      ),
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
