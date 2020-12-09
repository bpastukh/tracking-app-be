<?php

namespace App\TaskModule\Domain\Report;

final class Report
{
    private string $binaryReport;
    private string $format;

    private function __construct(string $report, string $format)
    {
        $this->binaryReport = $report;
        $this->format = $format;
    }

    public static function create(string $report, string $format): self
    {
        return new self($report, $format);
    }

    public function report(): string
    {
        return $this->binaryReport;
    }

    public function format(): string
    {
        return $this->format;
    }
}
