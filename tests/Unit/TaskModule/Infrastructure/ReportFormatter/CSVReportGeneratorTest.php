<?php

declare(strict_types=1);

namespace App\Test\Unit\TaskModule\Infrastructure\Report\ReportGenerator;

use App\TaskModule\Domain\Report\ReportDateRange;
use App\TaskModule\Domain\Report\ReportFormat;
use App\TaskModule\Domain\Task;
use App\TaskModule\Domain\TaskComment;
use App\TaskModule\Domain\TaskLoggedTime;
use App\TaskModule\Domain\TaskTitle;
use App\TaskModule\Domain\TaskUserId;
use App\TaskModule\Infrastructure\ReportFormatter\CSVReportFormatter;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

final class CSVReportGeneratorTest extends TestCase
{
    private const SAMPLE = __DIR__.'/snapshot.csv';

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
        $sampleCSV = file_get_contents(self::SAMPLE);

        self::assertSame($sampleCSV, $report->report());
        self::assertSame(ReportFormat::CSV_FORMAT, $report->format()->asString());
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
        $sampleCSV = file_get_contents(self::SAMPLE);

        self::assertNotSame($sampleCSV, $report->report());
    }
}
