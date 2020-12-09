<?php

declare(strict_types=1);

namespace App\Tests\TaskModule\Domain;

use App\TaskModule\Domain\Report\Report;
use App\TaskModule\Domain\Report\ReportDateRange;
use App\TaskModule\Domain\Report\ReportFormat;
use App\TaskModule\Domain\Report\ReportFormatter\PDFReportFormatter;
use App\TaskModule\Domain\Report\ReportGenerator;
use App\TaskModule\Domain\Report\ReportGeneratorBag;
use App\TaskModule\Domain\Task;
use App\TaskModule\Domain\TaskComment;
use App\TaskModule\Domain\TaskLoggedTime;
use App\TaskModule\Domain\TaskTitle;
use App\TaskModule\Domain\TaskUserId;
use App\TaskModule\Infrastructure\Persistence\DummyTaskRepository;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

final class ReportGeneratorTest extends TestCase
{
    public function testReportGenerated(): void
    {
        $pdfFormatter = new PDFReportFormatter();
        $bag = new ReportGeneratorBag();
        $bag->add($pdfFormatter);

        $userId = TaskUserId::create(Uuid::uuid1());
        $tasks = [
            Task::create(
                TaskTitle::create('first task'),
                TaskComment::create(''),
                new DateTimeImmutable(),
                TaskLoggedTime::create(10),
                $userId,
                ),
            Task::create(
                TaskTitle::create('second task'),
                TaskComment::create(''),
                new DateTimeImmutable(),
                TaskLoggedTime::create(30),
                $userId,
                ),
        ];

        $reportGenerator = new ReportGenerator($bag, new DummyTaskRepository($tasks));

        $format = ReportFormat::create(ReportFormat::PDF_FORMAT);
        $dateRange = ReportDateRange::create(new DateTimeImmutable('-1 day'), new DateTimeImmutable());
        $report = $reportGenerator->generate($format, $dateRange, $userId);

        self::assertInstanceOf(Report::class, $report);
    }
}
