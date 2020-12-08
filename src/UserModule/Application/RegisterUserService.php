<?php

declare(strict_types=1);

namespace App\UserModule\Application;

use App\UserModule\Domain\User\User;
use App\UserModule\Domain\User\UserEmail;
use App\UserModule\Domain\User\UserPassword;
use App\UserModule\Infrastructure\Persistence\UserRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
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
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(UserRepository $repository, UserPasswordEncoderInterface $encoder, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->encoder = $encoder;
        $this->em = $em;
    }

    public function register(string $email, string $password): User
    {
        $user = User::create($this->repository->nextIdentity(), UserEmail::create($email), UserPassword::create($password));
        $encodedPassword = $this->encoder->encodePassword($user, $password);
        $user->replacePassword(UserPassword::create($encodedPassword));

        $this->repository->add($user);

        try {
            $this->em->flush();
        } catch (UniqueConstraintViolationException $exception) {
        }

        return $user;
    }
}
