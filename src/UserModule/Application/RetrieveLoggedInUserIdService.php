<?php

declare(strict_types=1);

namespace App\UserModule\Application;

use App\UserModule\Domain\User\User;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Security;

final class RetrieveLoggedInUserIdService
{
    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function retrieve(): string
    {
        $user = $this->security->getUser();
        if (!$user instanceof User) {
            throw new AuthenticationException('Invalid user');
        }

        return $user->id()->asString();
    }
}
