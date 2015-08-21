<?php
	/**
	* DatabaseHandler
	**/
	class DatabaseHandler
	{
		public $db_server;
		public $db_username;
		public $db_password;

		function __construct()
		{
			$this->db_server = 'localhost';
			$this->db_username = 'root';
			$this->db_password = '';
			$this->Connect_to_Database();
		}

		function Connect_to_Database()
		{
			@$verbindung = mysql_connect($this->db_server, $this->db_username, $this->db_password) or die($string['mysql']['m.connect.error']); 
			@mysql_select_db('stundenplan', $verbindung) or die ($string['mysql']['m.select.db.error']);
		}
	}

?>