<?php

declare(strict_types=1);

namespace App\UserModule\Domain\User;

use Assert\Assertion;

final class UserEmail
{
    private string $email;

    private function __construct(string $email)
    {
        $this->email = $email;
    }

    public static function create(string $email): self
    {
        Assertion::email($email);

        return new self($email);
    }

    public function asString(): string
    {
        return $this->email;
    }
}
