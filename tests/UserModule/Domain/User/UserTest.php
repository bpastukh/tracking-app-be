<?php

declare(strict_types=1);

namespace App\Tests\UserModule\Domain\User;

use App\UserModule\Domain\User\User;
use App\UserModule\Domain\User\UserEmail;
use App\UserModule\Domain\User\UserId;
use App\UserModule\Domain\User\UserPassword;
use Assert\InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

final class UserTest extends TestCase
{
    public function testUserCreate(): void
    {
        $user = User::create(UserId::create(Uuid::uuid1()), UserEmail::create('dummy@email.com'), UserPassword::create('dummy-password'));

        self::assertInstanceOf(User::class, $user);
    }

    public function testInvalidUserEmail(): void
    {
        $this->expectException(InvalidArgumentException::class);
        User::create(UserId::create(Uuid::uuid1()), UserEmail::create('dummy'), UserPassword::create('dummy-password'));
    }

    public function testEmptyUserPassword(): void
    {
        $this->expectException(InvalidArgumentException::class);
        User::create(UserId::create(Uuid::uuid1()), UserEmail::create('dummy@email.com'), UserPassword::create(''));
    }
}
