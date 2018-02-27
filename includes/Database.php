<?php
/**
 * Created by PhpStorm.
 * User: Faisal Alam
 * Date: 27-02-2018
 * Time: 21:45
 */

class Database
{
    private static $mysqli;

    function __construct()
    {}

    public static function connect() {
        self::$mysqli = new mysqli(HOST, DBUSER, DBPWD, DBNAME);
        return self::$mysqli;
    }

    public static function disconnect() {
        self::$mysqli = NULL;
    }
}