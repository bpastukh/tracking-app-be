<?php

declare(strict_types=1);

namespace App\Tests\TaskModule\Domain;

use App\TaskModule\Domain\Task;
use App\TaskModule\Domain\TaskComment;
use App\TaskModule\Domain\TaskLoggedTime;
use App\TaskModule\Domain\TaskTitle;
use App\TaskModule\Domain\TaskUserId;
use Assert\InvalidArgumentException;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

final class TaskTest extends TestCase
{
    public function wrongTaskLoggedTimeProvider(): array
    {
        return [
            [0],
            [-10],
            [-100],
        ];
    }

    public function testTaskCreated(): void
    {
        $task = Task::create(
            TaskTitle::create('dummy-title'),
            TaskComment::create('comment'),
            new DateTimeImmutable(),
            TaskLoggedTime::create(10),
            TaskUserId::create(Uuid::uuid1())
        );

        self::assertInstanceOf(Task::class, $task);
    }

    /**
     * @dataProvider wrongTaskLoggedTimeProvider
     */
    public function testCreateTaskInvalidTimeExceptionThrown($time): void
    {
        $this->expectException(InvalidArgumentException::class);
        Task::create(
            TaskTitle::create('dummy-title'),
            TaskComment::create('comment'),
            new DateTimeImmutable(),
            TaskLoggedTime::create($time),
            TaskUserId::create(Uuid::uuid1())
        );
    }

    public function testCreateTaskEmptyTitleExceptionThrown(): void
    {
        $this->expectException(InvalidArgumentException::class);
        Task::create(
            TaskTitle::create(''),
            TaskComment::create('comment'),
            new DateTimeImmutable(),
            TaskLoggedTime::create(10),
            TaskUserId::create(Uuid::uuid1())
        );
    }
}
