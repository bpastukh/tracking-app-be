<?php

declare(strict_types=1);

namespace App\Tests\TaskModule\Domain;

use App\TaskModule\Domain\Report\ReportDateRange;
use Assert\InvalidArgumentException;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

final class ReportDateRangeTest extends TestCase
{
    public function testReportDateRangeCreated(): void
    {
        $dayAgo = new DateTimeImmutable('-1 day');
        $now = new DateTimeImmutable();
        $reportDateRange = ReportDateRange::create($dayAgo, $now);

        self::assertSame($dayAgo->getTimestamp(), $reportDateRange->dateFrom()->getTimestamp());
        self::assertSame($now->getTimestamp(), $reportDateRange->dateTo()->getTimestamp());
    }

    public function testReportDateRangeInvalidDateRangeExceptionThrown(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $dayAgo = new DateTimeImmutable('-1 day');
        $now = new DateTimeImmutable();
        ReportDateRange::create($now, $dayAgo);
    }
}
