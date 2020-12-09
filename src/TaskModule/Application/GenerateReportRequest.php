<?php

declare(strict_types=1);

namespace App\TaskModule\Application;

use Assert\Assert;

final class GenerateReportRequest
{
    private $format;

    private $dateFrom;

    private $dateTo;

    public function __construct($format, $dateFrom, $dateTo)
    {
        $this->validate($format, $dateFrom, $dateTo);

        $this->format = $format;
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
    }

    private function validate($format, $dateFrom, $dateTo): void
    {
        Assert::that(
            [$format, $dateFrom, $dateTo],
            'Bad request',
            )
            ->all()
            ->notNull()
            ->string();
    }

    public function format(): string
    {
        return $this->format;
    }

    public function dateFrom(): string
    {
        return $this->dateFrom;
    }

    public function dateTo(): string
    {
        return $this->dateTo;
    }
}
