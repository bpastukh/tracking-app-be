<?php

declare(strict_types=1);

namespace App\Tests\Stubs;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method bool needsRehash(UserInterface $user)
 */
final class DummyPasswordEncoder implements UserPasswordEncoderInterface
{
    public function encodePassword(UserInterface $user, $plainPassword)
    {
        return md5($plainPassword);
    }

    public function isPasswordValid(UserInterface $user, $raw)
    {
        return true;
    }

    public function __call(string $name, array $arguments)
    {
    }
}
