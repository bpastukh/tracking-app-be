<?php

declare(strict_types=1);

namespace App\UserModule\Infrastructure\Persistence;

use App\UserModule\Domain\User\User;
use App\UserModule\Domain\User\UserId;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;

final class DoctrineUserRepository implements UserRepository
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function nextIdentity(): UserId
    {
        return UserId::create(Uuid::uuid1());
    }

    public function add(User $user): void
    {
        $this->em->persist($user);
    }
}
