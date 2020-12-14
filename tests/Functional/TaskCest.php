<?php

namespace App\Tests;

use App\TaskModule\Domain\Task;
use Codeception\Util\HttpCode;

final class TaskCest
{
    public function created(FunctionalTester $I): void
    {
        $I->login($I);

        $I->sendPOST(
            '/api/task',
            [
                'createdAt' => '2020-01-01 00:00:00',
                'loggedTime' => 10,
                'title' => 'task cest 1',
                'comment' => 'dummy comment',
            ]
        );

        $I->seeResponseCodeIs(HttpCode::CREATED);
        $I->seeInRepository(Task::class, [
            'title' => 'task cest 1',
            'loggedTime' => 10,
        ]);
    }

    public function emptyTitleNotCreated(FunctionalTester $I): void
    {
        $I->login($I);

        $I->sendPOST(
            '/api/task',
            [
                'createdAt' => '2020-01-01 00:00:00',
                'loggedTime' => 10,
                'title' => '',
                'comment' => 'task cest 2',
            ]
        );

        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
        $I->cantSeeInRepository(Task::class, [
            'comment' => 'task cest 2',
        ]);
    }

    public function zeroLoggedTImeNotCreated(FunctionalTester $I): void
    {
        $I->login($I);

        $I->sendPOST(
            '/api/task',
            [
                'createdAt' => '2020-01-01 00:00:00',
                'loggedTime' => 0,
                'title' => 'task cest 3',
                'comment' => 'dummy comment',
            ]
        );

        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
        $I->cantSeeInRepository(Task::class, [
            'comment' => 'task cest 3',
        ]);
    }

    public function wrongDateFormatNotCreated(FunctionalTester $I): void
    {
        $I->login($I);

        $I->sendPOST(
            '/api/task',
            [
                'createdAt' => '01/01/10000',
                'loggedTime' => 10,
                'title' => 'task cest 4',
                'comment' => 'dummy comment',
            ]
        );

        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
        $I->cantSeeInRepository(Task::class, [
            'comment' => 'task cest 4',
        ]);
    }

    public function unauthorizedNotCreated(FunctionalTester $I): void
    {
        $I->logout($I);

        $I->sendPOST(
            '/api/task',
            [
                'createdAt' => '2020-01-01 00:00:00',
                'loggedTime' => 10,
                'title' => 'task cest 5',
                'comment' => 'dummy comment',
            ]
        );

        $I->seeResponseCodeIs(HttpCode::UNAUTHORIZED);
        $I->cantSeeInRepository(Task::class, [
            'comment' => 'task cest 5',
        ]);
    }
}
