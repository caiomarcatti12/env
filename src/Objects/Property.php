<?php

namespace CaioMarcatti12\Env\Objects;

use CaioMarcatti12\Core\Validation\Assert;

class Property
{
    private static array $payload = [];

    public static function add($key, $value): void{
        self::$payload[$key] = $value;
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        $keys = explode('.', $key);
        $payload = self::$payload;

        foreach ($keys as $k) {
            $payload = $payload[$k] ?? null;
            if (is_null($payload)) break;
        }

        return $payload ?? $default;
    }

    public static function has(string $key): bool
    {
        return Assert::isNotEmpty(self::get($key, ''));
    }
}