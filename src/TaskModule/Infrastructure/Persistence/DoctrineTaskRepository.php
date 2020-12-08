<?php

declare(strict_types=1);

namespace App\TaskModule\Infrastructure\Persistence;

use App\TaskModule\Domain\Task;
use Doctrine\ORM\EntityManagerInterface;

final class DoctrineTaskRepository implements TaskRepository
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function add(Task $task): void
    {
        $this->em->persist($task);
    }
}
