<?php

class database{

    private static $host = 'localhost';

    private static $user = 'root';

    private static $pass = '';

    private static $db = 'backup';

    private static $_connection = NULL;

    private static function _construct()
    {

    }

    public static function getConnection()
    {
        if (self::$_connection === NULL) {
            $conn = new mysqli(self::$host, self::$user, self::$pass, self::$db);
            if ($conn->connect_error) {
                die('errore di connessione');
            } else {
                self::$_connection = $conn;
            }
        }
        return self::$_connection;
    }
}
