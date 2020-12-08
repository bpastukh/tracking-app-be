<?php

declare(strict_types=1);

namespace App\UserModule\Application;

use App\UserModule\Domain\User\User;
use App\UserModule\Domain\User\UserEmail;
use App\UserModule\Domain\User\UserPassword;
use App\UserModule\Domain\UserRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

final class RegisterUserService
{
    /**
     * @var UserRepository
     */
    private $repository;

    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    /**
     * @var ObjectManager
     */
    private $om;

    public function __construct(UserRepository $repository, UserPasswordEncoderInterface $encoder,
                                ObjectManager $om)
    {
        $this->repository = $repository;
        $this->encoder = $encoder;
        $this->om = $om;
    }

    public function register(string $email, string $password): User
    {
        $user = User::create($this->repository->nextIdentity(), UserEmail::create($email), UserPassword::create($password));
        $encodedPassword = $this->encoder->encodePassword($user, $password);
        $user->replacePassword(UserPassword::create($encodedPassword));

        $this->repository->add($user);
        $this->om->flush();

        return $user;
    }
}
