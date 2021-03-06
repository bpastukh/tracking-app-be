<?php

declare(strict_types=1);

namespace App\TaskModule\Application;

use Assert\Assert;
use Assert\InvalidArgumentException;
use DateTimeImmutable;
use Exception;

final class CreateTaskRequest
{
    private string $title;

    private string $comment;

    private string $plainCreatedAt;

    private int $loggedTime;

    public function __construct(
        $title,
        $comment,
        $plainCreatedAt,
        $loggedTime
    ) {
        $this->validate($title, $comment, $plainCreatedAt, $loggedTime);

        $this->title = $title;
        $this->comment = $comment;
        $this->plainCreatedAt = $plainCreatedAt;
        $this->loggedTime = $loggedTime;
    }

    private function validate(
        $title,
        $comment,
        $plainCreatedAt,
        $loggedTime
    ): void {
        Assert::that(
            [$title, $comment, $plainCreatedAt, $loggedTime],
            'Bad request',
        )
            ->all()
            ->notNull();

        try {
            new DateTimeImmutable($plainCreatedAt);
        } catch (Exception $e) {
            throw new InvalidArgumentException('Invalid date format', 0);
        }
    }

    public function title(): string
    {
        return $this->title;
    }

    public function comment(): string
    {
        return $this->comment;
    }

    public function plainCreatedAt(): string
    {
        return $this->plainCreatedAt;
    }

    public function loggedTime(): int
    {
        return $this->loggedTime;
    }
}
