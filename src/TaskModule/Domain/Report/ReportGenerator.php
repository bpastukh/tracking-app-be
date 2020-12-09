<?php

declare(strict_types=1);

namespace App\TaskModule\Domain\Report;

use App\TaskModule\Domain\TaskUserId;
use App\TaskModule\Infrastructure\Persistence\TaskRepository;

final class ReportGenerator
{
    /**
     * @var ReportGeneratorBag
     */
    private $bag;

    /**
     * @var TaskRepository
     */
    private $repository;

    public function __construct(ReportGeneratorBag $bag, TaskRepository $repository)
    {
        $this->bag = $bag;
        $this->repository = $repository;
    }

    public function generate(ReportFormat $format, ReportDateRange $dateRange, TaskUserId $userId): Report
    {
        $reportGenerator = $this->bag->get($format);
        $tasks = $this->repository->findInRange($dateRange->dateFrom(), $dateRange->dateTo(), $userId);

        return $reportGenerator->generate($tasks, $dateRange);
    }
}
