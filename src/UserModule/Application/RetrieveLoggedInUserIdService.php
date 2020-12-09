<?php

declare(strict_types=1);

namespace App\UserModule\Application;

use App\UserModule\Domain\User\User;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Security;

final class RetrieveLoggedInUserIdService
{
    /**
     * @var Security
     */
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function retrieve(): string
    {
        return 'e3e420a4-3960-11eb-876d-acde48001122';
        $user = $this->security->getUser();
        if (!$user instanceof User) {
            throw new AuthenticationException('Invalid user');
        }

        return $user->id()->asString();
    }
}
