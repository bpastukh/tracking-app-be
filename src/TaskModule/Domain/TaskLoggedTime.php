<?php

declare(strict_types=1);

namespace App\TaskModule\Domain;

use Assert\Assertion;

final class TaskLoggedTime
{
    private int $time;

    private function __construct(int $time)
    {
        $this->time = $time;
    }

    public static function create(int $time): self
    {
        Assertion::min($time, 1, 'Logged time (in minutes) should be more than 1');

        return new self($time);
    }

    public function asNumber(): int
    {
        return $this->time;
    }
}
