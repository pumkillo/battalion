<?php
class Session
{
    public static function get(string $key): string
    {
        return $_SESSION[$key];
    }

    public static function set(string $key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    public static function unset(string $key): void
    {
        unset($_SESSION[$key]);
    }
}
