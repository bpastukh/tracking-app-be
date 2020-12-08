<?php

namespace App\UserModule\Domain;

use App\UserModule\Domain\User\User;
use App\UserModule\Domain\User\UserId;

interface UserRepository
{
    public function nextIdentity(): UserId;

    public function add(User $user): void;
}
