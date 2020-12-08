<?php

declare(strict_types=1);

namespace App\TaskModule\Domain;

use Assert\Assertion;

final class TaskTitle
{
    private string $title;

    private function __construct(string $title)
    {
        $this->title = $title;
    }

    public static function create(string $title): self
    {
        Assertion::notBlank($title, 'Title should not be blank');

        return new self($title);
    }

    public function asString(): string
    {
        return $this->title;
    }
}
