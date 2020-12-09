<?php

declare(strict_types=1);

namespace App\TaskModule\Domain\Report;

use Assert\Assertion;
use DateTimeInterface;

final class ReportDateRange
{
    private DateTimeInterface $dateFrom;
    private DateTimeInterface $dateTo;

    private function __construct(DateTimeInterface $dateFrom, DateTimeInterface $dateTo)
    {
        Assertion::min($dateTo->getTimestamp(), $dateFrom->getTimestamp(), 'Invalid date range');
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
    }

    public static function create(DateTimeInterface $dateFrom, DateTimeInterface $dateTo): self
    {
        return new self($dateFrom, $dateTo);
    }

    public function dateFrom(): DateTimeInterface
    {
        return $this->dateFrom;
    }

    public function dateTo(): DateTimeInterface
    {
        return $this->dateTo;
    }
}
