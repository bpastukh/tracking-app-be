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
    private const DEFAULT_LIST_LIMIT = 10;

    private EntityRepository $repository;

    private EntityManagerInterface $em;

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

    public function taskList(int $page, TaskUserId $userId): array
    {
        $offset = $page * self::DEFAULT_LIST_LIMIT;

        return $this
            ->repository
            ->createQueryBuilder('task')
            ->where('task.userId = :userId')
            ->setParameter('userId', $userId->asString())
            ->setMaxResults(self::DEFAULT_LIST_LIMIT)
            ->setFirstResult($offset)
            ->orderBy('task.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function taskPagesCount(TaskUserId $userId): int
    {
        $pagesCount = (int) $this
                ->repository
                ->createQueryBuilder('task')
                ->select('count(task.id)')
                ->where('task.userId = :userId')
                ->setParameter('userId', $userId->asString())
                ->getQuery()
                ->getSingleScalarResult();

        return (int) ceil($pagesCount / self::DEFAULT_LIST_LIMIT);
    }
}
