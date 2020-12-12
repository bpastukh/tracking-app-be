<?php

declare(strict_types=1);

namespace App\TaskModule\Domain;

use DateTimeInterface;

class Task
{
    private int $id;

    private string $title;

    private string $comment;

    private DateTimeInterface $createdAt;

    private int $loggedTime;

    private string $userId;

    private function __construct(
        TaskTitle $title,
        TaskComment $comment,
        DateTimeInterface $createdAt,
        TaskLoggedTime $loggedTime,
        TaskUserId $userId
    ) {
        $this->title = $title->asString();
        $this->comment = $comment->asString();
        $this->createdAt = $createdAt;
        $this->loggedTime = $loggedTime->asNumber();
        $this->userId = $userId->asString();
    }

    public static function create(
        TaskTitle $title,
        TaskComment $comment,
        DateTimeInterface $createdAt,
        TaskLoggedTime $loggedTime,
        TaskUserId $userId
    ): self {
        return new self($title, $comment, $createdAt, $loggedTime, $userId);
    }

    public function title(): TaskTitle
    {
        return TaskTitle::create($this->title);
    }

    public function comment(): TaskComment
    {
        return TaskComment::create($this->comment);
    }

    public function createdAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    public function loggedTime(): TaskLoggedTime
    {
        return TaskLoggedTime::create($this->loggedTime);
    }

    public function id(): int
    {
        return $this->id;
    }

    public function asArray(): array
    {
        return [
            'title' => $this->title,
            'comment' => $this->comment,
            'createdAt' => $this->createdAt->format('Y-m-d H:i:s'),
            'loggedTime' => $this->loggedTime,
        ];
    }
}
