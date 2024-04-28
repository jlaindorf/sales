<?php

class DatabaseUtils
{
    private static $connection;

    public static function getConnection()
    {
        if (!self::$connection) {
            self::$connection = new PDO("pgsql:host=localhost;dbname=api_sales", "admin", "admin");
        }
        return self::$connection;
    }
}
