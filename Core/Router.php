<?php
class Router
{
    private static $routes = [
        'main' => 'index.php',
        'login' => 'login.php',
        'logout' => 'logout.php',
        'staff' => 'staff.php'
    ];

    public static function redirect(string $route): void
    {
        header('Location: ' . self::$routes[$route]);
    }

    public static function get(string $key): string
    {
        return static::$routes[$key] ?? '#';
    }
}
