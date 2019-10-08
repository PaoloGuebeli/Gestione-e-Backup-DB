<?php

class database
{

	private static $host = 'localhost';

	private static $user = 'root';

	private static $pass = '';

	private static $db = 'backup';

	private static function _construct()
	{

	}

	public static function getConnection()
	{
		$conn = new mysqli(self::$host, self::$user, self::$pass, self::$db);
		if ($conn->connect_error) {
			die('errore di connessione');
		} else {
			return $conn;
		}
	}
}
