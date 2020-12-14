<?php

namespace App\Tests\Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

use App\Tests\FunctionalTester;
use Symfony\Component\BrowserKit\Cookie;

class Functional extends \Codeception\Module
{
    private const REGISTER_USER_ID = 'login_cest@email.com';

    private const REGISTER_USER_PASS = 'qwerty';

    public function login(FunctionalTester $I): void
    {
        $I->sendPost(
            '/login',
            [
                'email' => self::REGISTER_USER_ID,
                'password' => self::REGISTER_USER_PASS,
            ]
        );
    }

    public function logout(FunctionalTester $I): void
    {
        $I->sendPost('/logout');
    }

//    public function capturePHPSESSID(): Cookie
//    {
//        return $this->getClient()->getCookieJar()->get('PHPSESSID');
//    }
//
//    /**
//     * @return \Symfony\Component\HttpKernel\Client|\Symfony\Component\BrowserKit\Client $client
//     */
//    protected function getClient()
//    {
//        return $this->getModule('REST')->client;
//    }
}
