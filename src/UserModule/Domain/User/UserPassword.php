<?php

declare(strict_types=1);

namespace App\UserModule\Domain\User;

use Assert\Assertion;

final class UserPassword
{
    private string $password;

    private function __construct(string $password)
    {
        $this->password = $password;
    }

    public static function create(string $password): self
    {
        Assertion::notBlank($password);

        return new self($password);
    }

    public function asString(): string
    {
        return $this->password;
    }
}
