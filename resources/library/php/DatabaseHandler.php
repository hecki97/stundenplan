<?php
	/**
	* DatabaseHandler
	**/
	class DatabaseHandler
	{
		private static $mysqli;

		private function __construct() {}
		private static $initialized = false;

		private static function initialize() {
			if (self::$initialized) return;

			self::$mysqli = mysqli_connect(DATABASE_SERVER, DATABASE_USERNAME, DATABASE_PASSWORD);

			/* check connection */
			if (mysqli_connect_error()) {
    			die('Connect Error (' . mysqli_connect_errno().') '.mysqli_connect_error());
			}

			self::mkdatabase(DATABASE_NAME);
			mysqli_select_db(self::$mysqli, DATABASE_NAME);
			self::mktable("SELECT ID FROM ".DATABASE_TABLE_NAME, "CREATE TABLE ".DATABASE_TABLE_NAME." (id int(255) AUTO_INCREMENT, uuid varchar(255) NOT NULL, username varchar(255) NOT NULL, password_hash varchar(255) NOT NULL, encryption_key varchar(255) NOT NULL, PRIMARY KEY (id))");

			self::$initialized = true;
		}

		/**
		 * Checks if the given database exists and if not creates the database
		 * @param string $database
		 */
		private static function mkdatabase($database) {
			if (!mysqli_select_db(self::$mysqli, $database))
				mysqli_query(self::$mysqli, "CREATE DATABASE ".$database) or die('Error creating database: '.mysqli_error(self::$mysqli));
		}

		/**
		 * Checks if the result of the given query is empty and if true it creates a new table
		 * @param string $query
		 * @param string $sql
		 */
		private static function mktable($query, $sql) {
			$result = mysqli_query(self::$mysqli, $query);

			if (empty($result))
				mysqli_query(self::$mysqli, $sql) or die('Error creating table: '.mysqli_error(self::$mysqli));
		}

		/**
		 * Executes the given query and returns the result from the database
		 * @param string $query
		 */
		public static function MySqli_Query($query) {
			self::initialize();

			$result = mysqli_query(self::$mysqli, $query) or die ('Error while executing query: '.mysqli_error(self::$mysqli));
			return $result;
		}
	}
?>