<?php

declare(strict_types=1);

namespace App\TaskModule\Infrastructure\ReportFormatter;

use App\TaskModule\Domain\Report\Report;
use App\TaskModule\Domain\Report\ReportDateRange;
use App\TaskModule\Domain\Report\ReportFormat;
use App\TaskModule\Domain\Report\ReportFormatter;
use App\TaskModule\Domain\Task;
use RuntimeException;

final class CSVReportFormatter implements ReportFormatter
{
    public function generate(array $tasks, ReportDateRange $dateRange): Report
    {
        $buffer = $this->openBuffer();
        $this->writeHeader($buffer, $dateRange);
        $this->writeBody($buffer, $tasks);
        $csv = $this->getBufferContent($buffer);

        return Report::create($csv, $this->format());
    }

    public function format(): ReportFormat
    {
        return ReportFormat::create(ReportFormat::CSV_FORMAT);
    }

    private function writeHeader($buffer, ReportDateRange $dateRange): void
    {
        $dateFrom = $dateRange->dateFrom()->format('Y-m-d H:i:s');
        $dateTo = $dateRange->dateTo()->format('Y-m-d H:i:s');
        fputcsv(
            $buffer,
            ["{$dateFrom} - {$dateTo}"]
        );
    }

    private function writeBody($buffer, array $tasks): void
    {
        fputcsv($buffer, ['title', 'comment', 'created_at', 'duration']);

        $totalDuration = 0;
        /** @var Task $task */
        foreach ($tasks as $task) {
            $totalDuration += $task->loggedTime()->asNumber();
            fputcsv($buffer, $task->asArray());
        }

        fputcsv(
            $buffer, ['', '', '', "Total: $totalDuration"]
        );
    }

    private function openBuffer()
    {
        $buffer = fopen('php://memory', 'rb+');

        if (false === $buffer) {
            throw new RuntimeException("Can't open buffer");
        }

        return $buffer;
    }

    private function getBufferContent($buffer)
    {
        rewind($buffer);

        $csv = stream_get_contents($buffer);
        fclose($buffer);

        return $csv;
    }
}
