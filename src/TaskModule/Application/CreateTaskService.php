<?php

declare(strict_types=1);

namespace App\TaskModule\Application;

use App\TaskModule\Domain\Task;
use App\TaskModule\Domain\TaskComment;
use App\TaskModule\Domain\TaskLoggedTime;
use App\TaskModule\Domain\TaskTitle;
use App\TaskModule\Domain\TaskUserId;
use App\TaskModule\Infrastructure\Persistence\TaskRepository;
use App\UserModule\Application\RetrieveLoggedInUserIdService;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;

final class CreateTaskService
{
    private TaskRepository $repository;

    private EntityManagerInterface $em;

    private RetrieveLoggedInUserIdService $loggedInUserIdService;

    public function __construct(
        TaskRepository $repository,
        EntityManagerInterface $em,
        RetrieveLoggedInUserIdService $loggedInUserIdService)
    {
        $this->repository = $repository;
        $this->em = $em;
        $this->loggedInUserIdService = $loggedInUserIdService;
    }

    public function create(CreateTaskRequest $request): int
    {
        $loggedInUser = $this->loggedInUserIdService->retrieve();

        $task = Task::create(
            TaskTitle::create($request->title()),
            TaskComment::create($request->comment()),
            new DateTimeImmutable($request->plainCreatedAt()),
            TaskLoggedTime::create($request->loggedTime()),
            TaskUserId::create(Uuid::fromString($loggedInUser)),
        );

        $this->repository->add($task);
        $this->em->flush();

        return $task->id();
    }
}
