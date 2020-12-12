<?php

declare(strict_types=1);

namespace App\TaskModule\Application;

use App\TaskModule\Domain\Report\ReportDateRange;
use App\TaskModule\Domain\Report\ReportFormat;
use App\TaskModule\Domain\Report\ReportGenerator;
use App\TaskModule\Domain\TaskUserId;
use App\UserModule\Application\RetrieveLoggedInUserIdService;
use DateTimeImmutable;
use Ramsey\Uuid\Uuid;

final class GenerateReportService
{
    private ReportGenerator $reportGenerator;

    private RetrieveLoggedInUserIdService $loggedInUserIdService;

    public function __construct(ReportGenerator $reportGenerator, RetrieveLoggedInUserIdService $loggedInUserIdService)
    {
        $this->reportGenerator = $reportGenerator;
        $this->loggedInUserIdService = $loggedInUserIdService;
    }

    /**
     * @return array{report: string, format: string}
     */
    public function generate(GenerateReportRequest $request): array
    {
        $user = TaskUserId::create(Uuid::fromString($this->loggedInUserIdService->retrieve()));

        $reportObject = $this->reportGenerator->generate(
            ReportFormat::create($request->format()),
            ReportDateRange::create(
                new DateTimeImmutable($request->dateFrom()), new DateTimeImmutable($request->dateTo())
            ),
            $user
        );

        return ['report' => $reportObject->report(), 'format' => $reportObject->format()->asString()];
    }
}
