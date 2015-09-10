<?php
	/**
	* DatabaseHandler
	**/
	class DatabaseHandler
	{
		public $db_server = 'localhost';
		public $db_username;
		public $db_password;
		public $db_database;
		public $table_login;

		private $mysql_link;

		function __construct()
		{
			// $this->db_server = 'localhost';
			$this->db_username = 'root';
			$this->db_password = '';
			$this->db_database = 'stundenplan';
			$this->table_login = 'login';

			$this->mysql_link = mysql_connect($this->db_server, $this->db_username, $this->db_password) or die('Could not connect: '.mysql_error());
			$this->Create_database_if_not_exists("CREATE DATABASE ".$this->db_database);
			$this->Create_table_if_not_exists("SELECT ID FROM ".$this->table_login, "CREATE TABLE ".$this->table_login." (id int(255) AUTO_INCREMENT, username varchar(255) NOT NULL, password varchar(255) NOT NULL, PRIMARY KEY (id))");
		}

		function Create_database_if_not_exists($sql)
		{
			$db_selected = mysql_select_db($this->db_database, $this->mysql_link);
			
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