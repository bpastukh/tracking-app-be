<?php

declare(strict_types=1);

namespace App\UserModule\Domain\User;

use Symfony\Component\Security\Core\User\UserInterface;

class User implements UserInterface
{
    private string $id;

    private string $email;

    private string $password;

    private function __construct(UserId $id, UserEmail $email, UserPassword $password)
    {
        $this->id = $id->asString();
        $this->email = $email->asString();
        $this->password = $password->asString();
    }

    public static function create(UserId $id, UserEmail $email, UserPassword $password): self
    {
        return new self($id, $email, $password);
    }

    public function getRoles(): array
    {
        return [];
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function replacePassword(UserPassword $password): void
    {
        $this->password = $password->asString();
    }

    public function getSalt(): void
    {
    }

    public function getUsername(): string
    {
        return $this->email;
    }

    public function eraseCredentials(): void
    {
    }
}
