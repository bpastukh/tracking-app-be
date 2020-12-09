<?php

namespace App\TaskModule\Domain\Report\ReportFormatter;

use App\TaskModule\Domain\Report\Report;
use App\TaskModule\Domain\Report\ReportDateRange;
use App\TaskModule\Domain\Report\ReportFormat;

interface ReportFormatter
{
    public const TAG = 'report.report_formatter';

    public function generate(array $tasks, ReportDateRange $dateRange): Report;

    public function format(): ReportFormat;
}
