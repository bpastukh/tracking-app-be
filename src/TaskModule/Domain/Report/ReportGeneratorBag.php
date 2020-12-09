<?php

declare(strict_types=1);

namespace App\TaskModule\Domain\Report;

use App\TaskModule\Domain\Report\ReportFormatter\ReportFormatter;
use RuntimeException;

final class ReportGeneratorBag
{
    private $reportGenerators = [];

    public function get(ReportFormat $format): ReportFormatter
    {
        if (!array_key_exists($format->asString(), $this->reportGenerators)) {
            throw new RuntimeException("{$format->asString()} ReportGenerator is not available in ReportGeneratorBag");
        }

        return $this->reportGenerators[$format->asString()];
    }

    public function add(ReportFormatter $reportGenerator): void
    {
        $this->reportGenerators[$reportGenerator->format()->asString()] = $reportGenerator;
    }
}
