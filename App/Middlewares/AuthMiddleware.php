<?php
require_once(__DIR__ . '/../Loader.php');
require_once(Loader::load('router'));

class AuthMiddleware 
{
    public static function check(): void
    {
        if (!static::is()) {
            Router::redirect('login');
            exit();
        }
    }

    public static function is(): bool
    {
        if (isset($_SESSION['id'])) {
            return true;
        }
        return false;
    }
}
