<?php

declare(strict_types=1);

namespace App\TaskModule\Application;

use Assert\Assert;
use Assert\InvalidArgumentException;
use DateTimeImmutable;
use Exception;

final class GenerateReportRequest
{
    private string $format;

    private string $dateFrom;

    private string $dateTo;

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

        try {
            new DateTimeImmutable($dateFrom);
            new DateTimeImmutable($dateTo);
        } catch (Exception $e) {
            throw new InvalidArgumentException('Invalid date format', 0);
        }
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
