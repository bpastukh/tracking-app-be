<?php

declare(strict_types=1);

namespace App\Test\Unit\TaskModule\Domain\Report\ReportGenerator;

use App\TaskModule\Domain\Report\ReportDateRange;
use App\TaskModule\Domain\Report\ReportFormatter\CSVReportFormatter;
use App\TaskModule\Domain\Task;
use App\TaskModule\Domain\TaskComment;
use App\TaskModule\Domain\TaskLoggedTime;
use App\TaskModule\Domain\TaskTitle;
use App\TaskModule\Domain\TaskUserId;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

final class CSVReportGeneratorTest extends TestCase
{
    private const EXPECTED_CSV_RESULT = <<<CSV
"2020-12-08 23:00:00 - 2020-12-09 23:00:00"
title,comment,created_at,duration
"finished task 1",,"2020-12-08 23:05:00",10
,,,"Total: 10"

CSV;

    public function testCSVReportGenerated(): void
    {
        $userId = TaskUserId::create(Uuid::fromString('e3e420a4-3960-11eb-876d-acde48001122'));
        $tasks = [
            Task::create(
                TaskTitle::create('finished task 1'),
                TaskComment::create(''),
                new DateTimeImmutable('2020-12-08 23:05:00.0'),
                TaskLoggedTime::create(10),
                $userId,
                ),
        ];

        $generator = new CSVReportFormatter();
        $report = $generator->generate(
            $tasks, ReportDateRange::create(new DateTimeImmutable('2020-12-08 23:00:00'), new DateTimeImmutable('2020-12-09 23:00:00'))
        );

        self::assertSame(self::EXPECTED_CSV_RESULT, $report->report());
    }

    public function testCSVReportDifferentTassNotGenerated(): void
    {
        $userId = TaskUserId::create(Uuid::fromString('e3e420a4-3960-11eb-876d-acde48001122'));
        $tasks = [
            Task::create(
                TaskTitle::create('finished task 5'),
                TaskComment::create(''),
                new DateTimeImmutable('2020-12-08 23:05:00.0'),
                TaskLoggedTime::create(30),
                $userId,
                ),
        ];

        $generator = new CSVReportFormatter();
        $report = $generator->generate(
            $tasks, ReportDateRange::create(new DateTimeImmutable('2020-12-08 23:00:00'), new DateTimeImmutable('2020-12-09 23:00:00'))
        );

        self::assertNotSame(self::EXPECTED_CSV_RESULT, $report->report());
    }
}
