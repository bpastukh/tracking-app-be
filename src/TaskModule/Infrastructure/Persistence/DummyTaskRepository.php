<?php

declare(strict_types=1);

namespace App\TaskModule\Infrastructure\Persistence;

use App\TaskModule\Domain\Task;
use App\TaskModule\Domain\TaskUserId;
use DateTimeInterface;

final class DummyTaskRepository implements TaskRepository
{
    private array $tasksToReturn;

    public function __construct(array $tasksToReturn)
    {
        $this->tasksToReturn = $tasksToReturn;
    }

    public function add(Task $task): void
    {
    }

    public function findInRange(DateTimeInterface $dateFrom, DateTimeInterface $dateTo, TaskUserId $userId): array
    {
        return $this->tasksToReturn;
    }

    public function taskList(int $page, TaskUserId $userId): array
    {
        return $this->tasksToReturn;
    }
}
