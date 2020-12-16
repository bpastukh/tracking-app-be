<?php

namespace App\TaskModule\Domain\Report;

interface ReportFormatter
{
    public const TAG = 'report.report_formatter';

    public function generate(array $tasks, ReportDateRange $dateRange): Report;

    public function format(): ReportFormat;
}
