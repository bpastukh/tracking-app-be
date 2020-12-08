<?php

declare(strict_types=1);

namespace App\TaskModule\Infrastructure\Persistence;

use App\TaskModule\Domain\Task;

final class DummyTaskRepository implements TaskRepository
{
    public function add(Task $task): void
    {
    }
}
