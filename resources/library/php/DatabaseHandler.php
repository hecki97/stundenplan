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
			$this->Create_table_if_not_exists("SELECT ID FROM ".DATABASE_TABLE_LOGIN, "CREATE TABLE ".DATABASE_TABLE_LOGIN." (id int(255) AUTO_INCREMENT, username varchar(255) NOT NULL, password_hash varchar(255) NOT NULL, encryption_key varchar(255) NOT NULL, PRIMARY KEY (id))");
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

		public function Create_account_if_not_exists($username, $password_hash)
		{
			$result = mysql_query("SELECT `id` FROM `login` WHERE username LIKE '".$username."'") or die(mysql_error());
            $row = mysql_num_rows($result);

            if($row == 0) 
            {
                $result = mysql_query("INSERT INTO login (username, password_hash) VALUES ('".$username."', '".$password_hash."')") or die(mysql_error());
                $return = (@$result) ? 'RegistrationSuccess' : 'RegistrationError';
            }
            else 
              $return = 'AlreadyExists';

          	return $return;
		}

		public function Get_Password_Hash_from_database($username)
		{
			$result = mysql_query("SELECT username, password_hash FROM `login` WHERE username LIKE '".$username."' LIMIT 1") or die(mysql_error()); 
	    	if (empty($result))
	    		$return = 'NotFoundInDatabase';

	    	$row = mysql_fetch_object($result);
	    	$return = !empty($row) ? $row->password_hash : 'LoginFailed';

	      	return $return;
		}

		public function Generate_Encryption_Key()
		{
			$key = bin2hex(openssl_random_pseudo_bytes(32));
			mysql_query("UPDATE login SET `encryption_key`='".$key."' WHERE username LIKE '".$_SESSION['username']."'") or die(mysql_error());

			return $key;
		}

		public function Get_Encryption_Key_from_database()
		{
			$result = mysql_query("SELECT username, encryption_key FROM `login` WHERE username LIKE '".$_SESSION['username']."' LIMIT 1") or die(mysql_error());
	    	$row = mysql_fetch_object($result);

	      	return !empty($row) ? $row->encryption_key : die('Failed to get Encryption Key from Database');
		}
	}
?>