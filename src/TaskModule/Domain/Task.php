<?php

declare(strict_types=1);

namespace App\TaskModule\Domain;

use DateTimeInterface;

class Task
{
    private string $id;
    private string $title;
    private string $comment;
    private DateTimeInterface $createdAt;
    private int $loggedTime;
    private string $userId;

    private function __construct(TaskTitle $title, TaskComment $comment, DateTimeInterface $createdAt, TaskLoggedTime $loggedTime, TaskUserId $userId)
    {
        $this->title = $title->asString();
        $this->comment = $comment->asString();
        $this->createdAt = $createdAt;
        $this->loggedTime = $loggedTime->asNumber();
        $this->userId = $userId->asString();
    }

    public static function create(TaskTitle $title, TaskComment $comment, DateTimeInterface $createdAt, TaskLoggedTime $loggedTime, TaskUserId $userId): self
    {
        return new self($title, $comment, $createdAt, $loggedTime, $userId);
    }
}
