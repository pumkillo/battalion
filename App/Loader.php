<?php
session_start();

class Loader
{
    private static $set = [
        'constants' => __DIR__ . '/../Config/app.php',
        'views' => __DIR__ . '/../Views/',
        'query' => __DIR__ . '/../Core/Query.php',
        'validators' => __DIR__ . '/../Core/Validators.php',
        'router' => __DIR__ . '/../Core/Router.php',
        'session' => __DIR__.'/../Core/Session.php',
        'middlewares' => __DIR__ . '/../Core/Middlewares.php',
        'session' => __DIR__ . '/../Core/Session.php',
        'db_trait' => __DIR__.'/../Core/Traits/DbTrait.php',
    ];

    public static function load(string $key, string $view = ''): string
    {
        if ($key === 'views' && $view !== '') {
            return static::$set[strtolower($key)] . "$view.php";
        }
        return static::$set[strtolower($key)];
    }
}
