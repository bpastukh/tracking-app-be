<?php

namespace App\Tests;

use Codeception\Util\HttpCode;

final class ReportCest
{
    public function reportGenerated(FunctionalTester $I): void
    {
        $I->login($I);

        $I->sendGet(
            '/api/report',
            [
                'date-from' => '2020-01-01 00:00:00',
                'date-to' => '2020-01-02 00:00:00',
                'format' => 'pdf',
            ]
        );

        $I->seeResponseCodeIs(HttpCode::OK);
    }

    public function unknownFormatNotGenerated(FunctionalTester $I): void
    {
        $I->login($I);

        $I->sendGet(
            '/api/report',
            [
                'date-from' => '2020-01-01 00:00:00',
                'date-to' => '2020-01-02 00:00:00',
                'format' => 'unknown',
            ]
        );

        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
    }

    public function unauthorizedNotGenereated(FunctionalTester $I): void
    {
        $I->logout($I);

        $I->sendGet(
            '/api/report',
            [
                'date-from' => '2020-01-01 00:00:00',
                'date-to' => '2020-01-02 00:00:00',
                'format' => 'pdf',
            ]
        );

        $I->seeResponseCodeIs(HttpCode::UNAUTHORIZED);
    }
}
