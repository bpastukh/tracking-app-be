<?php

declare(strict_types=1);

namespace App\Tests\Application;

use App\Tests\Stubs\DummyEntityManager;
use App\Tests\Stubs\DummyPasswordEncoder;
use App\UserModule\Application\RegisterUserService;
use App\UserModule\Domain\User\User;
use App\UserModule\Infrastructure\Persistence\DummyUserRepository;
use PHPUnit\Framework\TestCase;

final class RegisterUserServiceTest extends TestCase
{
    /** @var RegisterUserService */
    private $service;

    public function setUp(): void
    {
        $this->service = new RegisterUserService(new DummyUserRepository(), new DummyPasswordEncoder(), new DummyEntityManager());
    }

    public function testUserRegistered(): void
    {
        $user = $this->service->register('dummy@email.com', 'dummy-password');

        self::assertInstanceOf(User::class, $user);
    }

    public function testPasswordHashed(): void
    {
        $plainPassword = 'dummy-password';
        $user = $this->service->register('dummy@email.com', $plainPassword);

        self::assertNotSame($plainPassword, $user->getPassword());
    }
}
