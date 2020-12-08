<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\ResponseCreator;
use App\TaskModule\Application\CreateTaskRequest;
use App\TaskModule\Application\CreateTaskService;
use Assert\InvalidArgumentException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(path="/api/task")
 */
final class TaskController
{
    /**
     * @Route("/create", methods={"POST"})
     */
    public function create(ResponseCreator $responseCreator, Request $request, CreateTaskService $service): JsonResponse
    {
        try {
            $title = $request->request->get('title');
            $comment = $request->request->get('comment');
            $plainCreatedAt = $request->request->get('createdAt');
            $loggedTime = $request->request->getInt('loggedTime');
            $service->create(new CreateTaskRequest($title, $comment, $plainCreatedAt, $loggedTime));
        } catch (InvalidArgumentException $exception) {
            return $responseCreator->createBadRequest(['message' => $exception->getMessage()]);
        }

        return $responseCreator->createResponse([], Response::HTTP_CREATED);
    }
}
