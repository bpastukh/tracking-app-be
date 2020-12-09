<?php

declare(strict_types=1);

namespace App\Tests\TaskModule\Domain;

use App\TaskModule\Domain\Report\ReportFormat;
use App\TaskModule\Domain\Report\ReportFormatter\PDFReportFormatter;
use App\TaskModule\Domain\Report\ReportGeneratorBag;
use PHPUnit\Framework\TestCase;
use RuntimeException;

final class ReportGeneratorBagTest extends TestCase
{
    public function testReportGeneratorAdded(): void
    {
        $reportGenerator = new PDFReportFormatter();
        $bag = new ReportGeneratorBag();
        $bag->add($reportGenerator);

        $format = ReportFormat::create(ReportFormat::PDF_FORMAT);
        $retrievedReportGenerator = $bag->get($format);
        self::assertSame($retrievedReportGenerator->format()->asString(), $format->asString());
    }

    public function testReportGeneratorNotExistsExceptionThrown(): void
    {
        $this->expectException(RuntimeException::class);
        $bag = new ReportGeneratorBag();
        $format = ReportFormat::create(ReportFormat::PDF_FORMAT);
        $bag->get($format);
    }
}
