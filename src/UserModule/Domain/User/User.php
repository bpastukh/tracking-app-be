<?php

declare(strict_types=1);

namespace App\UserModule\Domain\User;

class User
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
}
