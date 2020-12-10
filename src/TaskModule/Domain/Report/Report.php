<?php

namespace App\TaskModule\Domain\Report;

final class Report
{
    private string $binaryReport;
    private ReportFormat $format;

    private function __construct(string $report, ReportFormat $format)
    {
        $this->binaryReport = $report;
        $this->format = $format;
    }

    public static function create(string $report, ReportFormat $format): self
    {
        return new self($report, $format);
    }

    public function report(): string
    {
        return $this->binaryReport;
    }

    public function format(): ReportFormat
    {
        return $this->format;
    }
}
