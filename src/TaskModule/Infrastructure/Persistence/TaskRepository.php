<?php

namespace App\TaskModule\Infrastructure\Persistence;

use App\TaskModule\Domain\Task;
use App\TaskModule\Domain\TaskUserId;
use DateTimeInterface;

interface TaskRepository
{
    public function add(Task $task): void;

    /**
     * @return Task[]
     */
    public function findInRange(DateTimeInterface $dateFrom, DateTimeInterface $dateTo, TaskUserId $userId): array;

    /**
     * @return Task[]
     */
    public function taskList(int $page, TaskUserId $userId): array;

    public function taskPagesCount(TaskUserId $userId): int;
}
