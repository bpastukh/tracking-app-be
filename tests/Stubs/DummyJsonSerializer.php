<?php

declare(strict_types=1);

namespace App\Tests\Stubs;

use JMS\Serializer\DeserializationContext;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;

final class DummyJsonSerializer implements SerializerInterface
{
    public function serialize($data, string $format, ?SerializationContext $context = null, ?string $type = null): string
    {
        return json_encode($data, JSON_THROW_ON_ERROR);
    }

    public function deserialize(string $data, string $type, string $format, ?DeserializationContext $context = null)
    {
        return json_decode($data, true, 512, JSON_THROW_ON_ERROR);
    }
}
