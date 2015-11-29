<?php
	/**
	* DatabaseHandler
	**/
	class DatabaseHandler
	{
		//private static $mysql_link;
		private static $mysqli;

		private function __construct() {}
		private static $initialized = false;

		private static function initialize() {
			if (self::$initialized) return;
			require_once(PROJECT_DIR.'/bootstrap.php');

			self::$mysqli = mysqli_connect(DATABASE_SERVER, DATABASE_USERNAME, DATABASE_PASSWORD);

			/* check connection */
			if (mysqli_connect_error()) {
    			die('Connect Error (' . mysqli_connect_errno().') '.mysqli_connect_error());
			}

			self::Create_database_if_not_exists("CREATE DATABASE ".DATABASE);
			self::Create_table_if_not_exists("SELECT ID FROM ".DATABASE_TABLE_LOGIN, "CREATE TABLE ".DATABASE_TABLE_LOGIN." (id int(255) AUTO_INCREMENT, uuid varchar(255) NOT NULL, username varchar(255) NOT NULL, password_hash varchar(255) NOT NULL, encryption_key varchar(255) NOT NULL, unique_filename varchar(255) NOT NULL, PRIMARY KEY (id))");

			self::$initialized = true;
		}

		private static function Create_database_if_not_exists($sql) {
			if (!mysqli_select_db(self::$mysqli, DATABASE))
				mysqli_query(self::$mysqli, $sql) or die('Error creating database: '.mysqli_error(self::$mysqli));
			else
				mysqli_select_db(self::$mysqli, DATABASE);
		}

		private static function Create_table_if_not_exists($query, $sql) {
			$result = mysqli_query(self::$mysqli, $query);

			if (empty($result))
				mysqli_query(self::$mysqli, $sql) or die('Error creating table: '.mysqli_error(self::$mysqli));
		}

		public static function MySqli_Query($query) {
			self::initialize();
			$result = mysqli_query(self::$mysqli, $query) or die ('Error while executing query: '.mysqli_error(self::$mysqli));
			return $result;
		}
	}
?>