<?php

namespace App\TaskModule\Infrastructure\Persistence;

use App\TaskModule\Domain\Task;

interface TaskRepository
{
    public function add(Task $task): void;
}
