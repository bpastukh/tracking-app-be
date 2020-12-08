<?php

declare(strict_types=1);

namespace App\TaskModule\Domain;

final class TaskComment
{
    private string $comment;

    private function __construct(string $comment)
    {
        $this->comment = $comment;
    }

    public static function create(string $comment): self
    {
        return new self($comment);
    }

    public function asString(): string
    {
        return $this->comment;
    }
}
