<?php

declare(strict_types = 1);

namespace Api;

class ResponseDeserializer
{
    public function deserialize(string $response): array
    {
        return json_decode($response, true);
    }
}