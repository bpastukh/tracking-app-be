<?php

declare(strict_types=1);

namespace App\TaskModule\Infrastructure\Persistence;

use App\TaskModule\Domain\Task;
use App\TaskModule\Domain\TaskUserId;
use DateTimeInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

final class DoctrineTaskRepository implements TaskRepository
{
    /**
     * @var EntityRepository
     */
    private $repository;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        /** @var EntityRepository $repository */
        $repository = $em->getRepository(Task::class);
        $this->repository = $repository;
        $this->em = $em;
    }

    public function add(Task $task): void
    {
        $this->em->persist($task);
    }

    public function findInRange(DateTimeInterface $dateFrom, DateTimeInterface $dateTo, TaskUserId $userId): array
    {
        return $this
            ->repository
            ->createQueryBuilder('task')
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
