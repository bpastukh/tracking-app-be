<?php

declare(strict_types=1);

namespace App\UserModule\Infrastructure\Persistence;

use App\UserModule\Domain\User\User;
use App\UserModule\Domain\User\UserId;
use Ramsey\Uuid\Uuid;

final class DummyUserRepository implements UserRepository
{
    public function nextIdentity(): UserId
    {
        return UserId::create(Uuid::uuid1());
    }

    public function add(User $user): void
    {
    }
}
