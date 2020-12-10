<?php

declare(strict_types=1);

namespace App\TaskModule\Domain\Report\ReportFormatter;

use App\TaskModule\Domain\Report\Report;
use App\TaskModule\Domain\Report\ReportDateRange;
use App\TaskModule\Domain\Report\ReportFormat;
use App\TaskModule\Domain\Task;

final class CSVReportFormatter implements ReportFormatter
{
    public function generate(array $tasks, ReportDateRange $dateRange): Report
    {
        $buffer = fopen('php://memory', 'rb+');

        $dateFrom = $dateRange->dateFrom()->format('Y-m-d H:i:s');
        $dateTo = $dateRange->dateTo()->format('Y-m-d H:i:s');
        fputcsv(
            $buffer,
            ["{$dateFrom} - {$dateTo}"]
        );

        fputcsv($buffer, ['title', 'comment', 'created_at', 'duration']);

        $totalDuration = 0;
        /** @var Task $task */
        foreach ($tasks as $task) {
            $totalDuration += $task->loggedTime()->asNumber();
            fputcsv(
                $buffer,
                [
                    $task->title()->asString(),
                    $task->comment()->asString(),
                    $task->createdAt()->format('Y-m-d H:i:s'),
                    $task->loggedTime()->asNumber(),
                ]
            );
        }

        fputcsv(
            $buffer, ['', '', '', "Total: $totalDuration"]
        );

        rewind($buffer);

        $csv = stream_get_contents($buffer);
        fclose($buffer);

        return Report::create($csv, $this->format());
    }

    public function format(): ReportFormat
    {
        return ReportFormat::create(ReportFormat::CSV_FORMAT);
    }
}
