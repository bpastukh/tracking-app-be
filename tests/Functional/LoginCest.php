<?php

namespace App\Tests;

use Codeception\Util\HttpCode;

final class LoginCest
{
    private const REGISTER_USER_ID = 'login_cest@email.com';
    private const REGISTER_USER_PASS = 'qwerty';

    public function _before(FunctionalTester $I)
    {
        $I->sendPost(
            '/register',
            [
                'email' => self::REGISTER_USER_ID,
                'password' => self::REGISTER_USER_PASS,
            ]
        );
    }

    public function userLoggedIn(FunctionalTester $I): void
    {
        $I->sendPost(
            '/login',
            [
                'email' => self::REGISTER_USER_ID,
                'password' => self::REGISTER_USER_PASS,
            ]
        );

        $I->seeResponseCodeIs(HttpCode::OK);
    }

    public function wrongPasswordNotLoggedIn(FunctionalTester $I): void
    {
        $email = 'login_cest2@email.com';
        $plainTextPassword = 'qwerty123';
        $I->sendPost(
            '/login',
            [
                'email' => $email,
                'password' => $plainTextPassword,
            ]
        );

        $I->seeResponseCodeIs(HttpCode::UNAUTHORIZED);
    }
}
