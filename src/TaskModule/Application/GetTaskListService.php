<?php

declare(strict_types=1);

namespace App\TaskModule\Application;

use App\TaskModule\Domain\TaskUserId;
use App\TaskModule\Infrastructure\Persistence\TaskRepository;
use App\UserModule\Application\RetrieveLoggedInUserIdService;
use Ramsey\Uuid\Uuid;

final class GetTaskListService
{
    private RetrieveLoggedInUserIdService $loggedInUserIdService;

    private TaskRepository $repository;

    public function __construct(RetrieveLoggedInUserIdService $loggedInUserIdService, TaskRepository $repository)
    {
        $this->loggedInUserIdService = $loggedInUserIdService;
        $this->repository = $repository;
    }

    public function get(int $page): array
    {
        $userId = TaskUserId::create(Uuid::fromString($this->loggedInUserIdService->retrieve()));
        $tasks = $this->repository->taskList($page, $userId);

        return array_map(static fn ($task) => $task->asArray(), $tasks);
    }
}
