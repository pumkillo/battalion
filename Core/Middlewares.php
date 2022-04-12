<?php
class Middlewares
{
    private static $middlewares = [
        'auth' => 'AuthMiddleware',
    ];

    public static function getClass(string $key): string
    {
        return __DIR__ . '/../App/Middlewares/' . static::$middlewares[strtolower($key)]. '.php';
    }
}
