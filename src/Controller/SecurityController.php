<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\ResponseCreator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

final class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="login", methods={"POST"})
     */
    public function login(ResponseCreator $responseCreator): JsonResponse
    {
        return $responseCreator->createOK();
    }
}
