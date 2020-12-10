<?php

declare(strict_types=1);

namespace App\Tests\TaskModule\Domain;

use App\TaskModule\Domain\Report\ReportFormat;
use Assert\InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class ReportFormatTest extends TestCase
{
    public function testReportFormatCreated(): void
    {
        $reportFormat = ReportFormat::create(ReportFormat::XLSX_FORMAT);

        self::assertSame(ReportFormat::XLSX_FORMAT, $reportFormat->asString());
    }

    public function testReportFormatInvalidFormatExceptionThrown(): void
    {
        $this->expectException(InvalidArgumentException::class);
        ReportFormat::create('dummy-format');
    }
}
