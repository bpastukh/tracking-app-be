<?php

declare(strict_types=1);

namespace App\TaskModule\Infrastructure\Persistence;

use App\TaskModule\Domain\Task;
use App\TaskModule\Domain\TaskUserId;
use DateTimeInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class DoctrineTaskRepository extends ServiceEntityRepository implements TaskRepository
{
    /**
     * @var ManagerRegistry
     */
    private $registry;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
        $this->registry = $registry;
    }

    public function add(Task $task): void
    {
        $this->registry->getManager()->persist($task);
    }

    public function findInRange(DateTimeInterface $dateFrom, DateTimeInterface $dateTo, TaskUserId $userId): array
    {
        return $this->createQueryBuilder('task')
            ->where('task.userId = :userId')
            ->andWhere('task.createdAt > :dateFrom')
            ->andWhere('task.createdAt < :dateTo')
            ->setParameters(
                [
                    'userId' => $userId->asString(),
                    'dateFrom' => $dateFrom->format('Y-m-d H:i:s'),
                    'dateTo' => $dateTo->format('Y-m-d H:i:s'),
                ]
            )
            ->getQuery()
            ->getResult();
    }
}
