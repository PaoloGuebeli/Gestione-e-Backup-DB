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

	public static function dump($host, $user, $pass, $db, $dir){
		exec("mysqldump --column-statistics=0 --user={$user} --password={$pass} --host={$host} {$db} --result-file={$dir} 2>&1", $output);
		return $output;
	}
}
