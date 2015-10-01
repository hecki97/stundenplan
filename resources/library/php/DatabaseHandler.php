<?php
	/**
	* DatabaseHandler
	**/
	class DatabaseHandler
	{
		private $mysql_link;

		function __construct()
		{
			require_once('ConfigHandler.php');

			$this->mysql_link = mysql_connect(DATABASE_SERVER, DATABASE_USERNAME, DATABASE_PASSWORD) or die('Could not connect: '.mysql_error());
			$this->Create_database_if_not_exists("CREATE DATABASE ".DATABASE);
			$this->Create_table_if_not_exists("SELECT ID FROM ".DATABASE_TABLE_LOGIN, "CREATE TABLE ".DATABASE_TABLE_LOGIN." (id int(255) AUTO_INCREMENT, username varchar(255) NOT NULL, password varchar(255) NOT NULL, PRIMARY KEY (id))");
		}

		function Create_database_if_not_exists($sql)
		{
			$db_selected = mysql_select_db(DATABASE, $this->mysql_link);
			
			if (!$db_selected)
				mysql_query($sql, $this->mysql_link) or die('Error creating database: '.mysql_error());
		}

		function Create_table_if_not_exists($query, $sql)
		{
			$result = mysql_query($query, $this->mysql_link);

			if (empty($result))
				mysql_query($sql, $this->mysql_link) or die('Error creating table: '.mysql_error());
		}
	}
?>