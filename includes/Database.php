<?php

class Database
{
    private static $db;

    public static function getConnection($params)
    {
        if (!isset(self::$db))
        {
            $dsn = "{$params['type']}:host={$params['host']};dbname={$params['dbname']}";
            self::$db = new PDO($dsn, $params['user'], $params['password']);
        }
        return self::$db;
    }
}