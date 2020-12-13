<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\ResponseCreator;
use App\TaskModule\Application\CreateTaskRequest;
use App\TaskModule\Application\CreateTaskService;
use App\TaskModule\Application\GetTaskListService;
use App\TaskModule\Application\GetTotalTaskService;
use Assert\InvalidArgumentException;
use Swagger\Annotations as SWG;
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
     * @SWG\Response(
     *     response=201,
     *     description="Creates new task"
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
     *              @SWG\Property(property="title", type="string", example="New task"),
     *              @SWG\Property(property="comment", type="string", example="Task comment"),
     *              @SWG\Property(property="loggedTime", type="integer", example="10"),
     *              @SWG\Property(property="crreatedAt", type="string", example="2020-12-10 11:20"),
     *          )
     *
     *      ),
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
     * * @SWG\Response(
     *     response=200,
     *     description="Returns list with available tasks"
     *     )
     * )
     * @SWG\Response(
     *     response=400,
     *     description="Bad request"
     *     )
     * )
     * @SWG\Parameter(
     *          name="page",
     *          in="query",
     *          type="integer",
     *          description="Page to show",
     *          required=true,
     *      ),
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
