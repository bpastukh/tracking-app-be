<?php

declare(strict_types=1);

namespace App\TaskModule\Domain\Report\ReportFormatter;

use App\TaskModule\Domain\Report\Report;
use App\TaskModule\Domain\Report\ReportDateRange;
use App\TaskModule\Domain\Report\ReportFormat;
use App\TaskModule\Domain\Task;
use SimpleXLSXGen;

final class XLSXReportFormatter implements ReportFormatter
{
    public function generate(array $tasks, ReportDateRange $dateRange): Report
    {
        $dateFrom = $dateRange->dateFrom()->format('Y-m-d H:i:s');
        $dateTo = $dateRange->dateTo()->format('Y-m-d H:i:s');

        $prepared = [
            ["{$dateFrom} - {$dateTo}"],
            ['title', 'comment', 'created_at', 'duration'],
        ];

        $totalDuration = 0;
        /** @var Task $task */
        foreach ($tasks as $task) {
            $totalDuration += $task->loggedTime()->asNumber();
            $prepared[] = [
                $task->title()->asString(),
                $task->comment()->asString(),
                $task->loggedTime()->asNumber(),
                $task->createdAt()->format('Y-m-d H:i:s'),
            ];
        }

        $prepared[] = ['', '', '', "Total: $totalDuration"];

        /** @var SimpleXLSXGen $xlsx */
        $xlsx = SimpleXLSXGen::fromArray($prepared);

        return Report::create($xlsx->__toString(), $this->format());
    }

    public function format(): ReportFormat
    {
        return ReportFormat::create(ReportFormat::XLSX_FORMAT);
    }
}
