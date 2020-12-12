<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\ResponseCreator;
use App\TaskModule\Application\CreateTaskRequest;
use App\TaskModule\Application\CreateTaskService;
use App\TaskModule\Application\GetTaskListService;
use App\TaskModule\Application\GetTotalTaskService;
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
     * @Route(methods={"POST"})
     */
    public function create(ResponseCreator $responseCreator, Request $request, CreateTaskService $service): JsonResponse
    {
        try {
            $title = $request->request->get('title');
            $comment = $request->request->get('comment');
            $plainCreatedAt = $request->request->get('createdAt');
            $loggedTime = $request->request->getInt('loggedTime');
            $id = $service->create(new CreateTaskRequest($title, $comment, $plainCreatedAt, $loggedTime));

            return $responseCreator->create(['id' => $id], Response::HTTP_CREATED);
        } catch (InvalidArgumentException $exception) {
            return $responseCreator->create(['message' => $exception->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Route(methods={"GET"})
     */
    public function taskList(
        ResponseCreator $responseCreator,
        Request $request,
        GetTaskListService $taskListService,
        GetTotalTaskService $totalTaskService
    ): JsonResponse {
        $page = $request->query->getInt('page', 1);
        if ($page < 1) {
            return $responseCreator->create(['message' => 'Page must be bigger than 1'], Response::HTTP_BAD_REQUEST);
        }
        $tasks = $taskListService->get($page);
        $total = $totalTaskService->get();
        $payload = ['items' => $tasks, 'totalPages' => $total];

        return $responseCreator->create($payload);
    }
}
