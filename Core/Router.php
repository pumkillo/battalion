<?php
class Router
{
    private static $routes = [
        'main' => 'index.php',
        'login' => 'login.php',
        'logout' => 'logout.php',
        'add_employee' => 'add_employee.php',
        'add_company' => 'add_company.php',
        'add_platoon' => 'add_platoon.php',
        'add_division' => 'add_division.php',
        'fire' => 'fire.php',
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
