<?php

declare(strict_types=1);

namespace App\Tests\Service;

use App\Service\JsonResponseCreator;
use App\Tests\Stubs\DummyJsonSerializer;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class JsonResponseCreatorTest extends TestCase
{
    /**
     * @var JsonResponseCreator
     */
    private $service;

    protected function setUp(): void
    {
        $this->service = new JsonResponseCreator(new DummyJsonSerializer());
    }

    public function testCreateResponseIsJson(): void
    {
        $response = $this->service->createResponse([]);

        self::assertSame(get_class($response), JsonResponse::class);
    }

    public function testCreateOk(): void
    {
        $response = $this->service->createOK([]);

        self::assertSame($response->getStatusCode(), Response::HTTP_OK);
    }

    public function testCreateBadRequest(): void
    {
        $response = $this->service->createBadRequest([]);

        self::assertSame($response->getStatusCode(), Response::HTTP_BAD_REQUEST);
    }
}
