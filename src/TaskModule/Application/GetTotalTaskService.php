<?php

declare(strict_types=1);

namespace App\TaskModule\Application;

use App\TaskModule\Domain\TaskUserId;
use App\TaskModule\Infrastructure\Persistence\TaskRepository;
use App\UserModule\Application\RetrieveLoggedInUserIdService;
use Ramsey\Uuid\Uuid;

final class GetTotalTaskService
{
    private RetrieveLoggedInUserIdService $loggedInUserIdService;

    private TaskRepository $repository;

    public function __construct(RetrieveLoggedInUserIdService $loggedInUserIdService, TaskRepository $repository)
    {
        $this->loggedInUserIdService = $loggedInUserIdService;
        $this->repository = $repository;
    }

    public function get(): int
    {
        $userId = TaskUserId::create(Uuid::fromString($this->loggedInUserIdService->retrieve()));

        return $this->repository->taskPagesCount($userId);
    }
}
