<?php

declare(strict_types=1);

namespace App\Test\Unit\TaskModule\Domain\Report\ReportGenerator;

use App\TaskModule\Domain\Report\ReportDateRange;
use App\TaskModule\Domain\Report\ReportFormat;
use App\TaskModule\Domain\Report\ReportFormatter\XLSXReportFormatter;
use App\TaskModule\Domain\Task;
use App\TaskModule\Domain\TaskComment;
use App\TaskModule\Domain\TaskLoggedTime;
use App\TaskModule\Domain\TaskTitle;
use App\TaskModule\Domain\TaskUserId;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

final class XLSXReportGeneratorTest extends TestCase
{
    private const SAMPLE = __DIR__.'/snapshot.xlsx';

    public function testXLSXReportGenerated(): void
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
            Task::create(
                TaskTitle::create('finished task 2'),
                TaskComment::create('comment'),
                new DateTimeImmutable('2020-12-08 23:15:00.0'),
                TaskLoggedTime::create(15),
                $userId,
                ),
            Task::create(
                TaskTitle::create('finished task 3'),
                TaskComment::create(''),
                new DateTimeImmutable('2020-12-08 23:05:00.0'),
                TaskLoggedTime::create(30),
                $userId,
                ),
        ];

        $generator = new XLSXReportFormatter();
        $report = $generator->generate(
            $tasks, ReportDateRange::create(new DateTimeImmutable('2020-12-08 23:00:00'), new DateTimeImmutable('2020-12-09 23:00:00'))
        );

        // todo not stable result, check better solution
        $sampleXLSX = filesize(self::SAMPLE);

        self::assertSame(strlen($report->report()), $sampleXLSX);
        self::assertSame(ReportFormat::XLSX_FORMAT, $report->format()->asString());
    }

    public function testXLSXReportDifferentTassNotGenerated(): void
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

        $generator = new XLSXReportFormatter();
        $report = $generator->generate(
            $tasks, ReportDateRange::create(new DateTimeImmutable('2020-12-08 23:00:00'), new DateTimeImmutable('2020-12-09 23:00:00'))
        );

        $sampleXLSX = filesize(self::SAMPLE);

        self::assertNotSame(strlen($report->report()), $sampleXLSX);
    }
}
