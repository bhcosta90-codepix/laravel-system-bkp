<?php

declare(strict_types=1);

namespace Tests\Stub\Services;

class Data
{
    public static function get(string $key): array
    {
        $data = json_decode(file_get_contents(__DIR__ . '/data.json'), true);
        return $data[$key];
    }
}
