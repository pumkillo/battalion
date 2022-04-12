<?php
trait dbConnection
{
    public function connect()
    {
        $mysqli = new mysqli('localhost', 'root', '', 'battalion');
        if (mysqli_connect_errno()) {
            echo "Не удалось подключиться к MySQL: " . mysqli_connect_error();
            return;
        }
        return $mysqli;
    }
}
