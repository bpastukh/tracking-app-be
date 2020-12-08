<?php

declare(strict_types=1);

namespace App\UserModule\Domain\User;

use Ramsey\Uuid\UuidInterface;

final class UserId
{
    private $uuid;

    private function __construct(UuidInterface $uuid)
    {
        $this->uuid = $uuid;
    }

    public static function create(UuidInterface $uuid): self
    {
        return new self($uuid);
    }

    public function asString(): string
    {
        return $this->uuid->toString();
    }
}
