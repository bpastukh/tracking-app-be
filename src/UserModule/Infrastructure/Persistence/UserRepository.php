<?php

namespace App\UserModule\Infrastructure\Persistence;

use App\UserModule\Domain\User\User;
use App\UserModule\Domain\User\UserId;

interface UserRepository
{
    public function nextIdentity(): UserId;

    public function add(User $user): void;
}
