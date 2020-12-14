<?php

namespace App\Tests;

use App\UserModule\Domain\User\User;
use Codeception\Util\HttpCode;
use Doctrine\Common\Collections\Criteria;

final class RegisterCest
{
    public function userRegistered(FunctionalTester $I): void
    {
        $email = 'register_cest@email.com';
        $plainTextPassword = 'qwerty';
        $I->sendPost(
            '/register',
            [
                'email' => $email,
                'password' => $plainTextPassword,
            ]
        );

        $I->seeResponseCodeIs(HttpCode::CREATED);
        // check user exists and password was hashed
        $I->seeInRepository(
            User::class,
            [
                'email' => $email,
                Criteria::create()->where(
                    Criteria::expr()->neq('password', $plainTextPassword),
                ),
            ]
        );
    }

    public function emptyPasswordNotRegistered(FunctionalTester $I): void
    {
        $email = 'register_cest2@email.com';
        $I->sendPost(
            '/register',
            [
                'email' => $email,
                'password' => '',
            ]
        );

        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
        $I->cantSeeInRepository(
            User::class,
            [
                'email' => $email,
            ]
        );
    }
}
