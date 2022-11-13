<?php

namespace CaioMarcatti12\Env;

class Env
{
    public static function get(string $key, mixed $default = null): mixed
    {
        return $_ENV[$key] ?? $default;
    }

    public static function has(string $key): bool
    {
        return isset($_ENV[$key]);
    }
}