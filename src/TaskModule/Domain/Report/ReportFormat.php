<?php

declare(strict_types=1);

namespace App\TaskModule\Domain\Report;

use Assert\Assertion;

final class ReportFormat
{
    public const PDF_FORMAT = 'pdf';
    public const CSV_FORMAT = 'csv';
    public const XLSX_FORMAT = 'xlsx';
    private const AVAILABLE_FORMATS = [self::PDF_FORMAT, self::CSV_FORMAT, self::XLSX_FORMAT];

    private string $format;

    private function __construct(string $format)
    {
        $format = strtolower($format);
        Assertion::inArray($format, self::AVAILABLE_FORMATS, 'Invalid report format');
        $this->format = $format;
    }

    public static function create(string $format): self
    {
        return new self($format);
    }

    public function asString(): string
    {
        return $this->format;
    }
}
