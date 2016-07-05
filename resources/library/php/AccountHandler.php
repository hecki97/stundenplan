<?php
	use Utilities\Dir;
	use Utilities\UUID;
	/**
	* AccountHandler
	*/
	class AccountHandler
	{
		private static $initialized = false;

		private static function initialize() {
			if (self::$initialized) return;

			Dir::include_file('Resources.Library.Php.DatabaseHandler');
			Dir::include_file('Resources.Library.Php.Utilities');

			self::$initialized = true;
		}

		public static function IsUserLoggedIn() {
			return isset($_SESSION['username']);
		}

		public static function Register_new_user($data) {
			self::initialize();
			$username = strip_tags($data[0]); $password = strip_tags($data[1]);

			if(!empty($username) && !empty($password)) {
		    	$rows = DatabaseHandler::MySqli_Query("SELECT `id` FROM `login` WHERE username LIKE '".$username."'");
		    	$num_rows = mysqli_num_rows($rows);
		    	if($num_rows == 0) 
		    	{
		        	$result = DatabaseHandler::MySqli_Query("INSERT INTO login (uuid, username, password_hash) VALUES ('".UUID::v4()."', '".$username."', '".password_hash($password, PASSWORD_DEFAULT)."')");
		        	return (@$result) ? 'RegistrationSuccess' : 'RegistrationError';
		        	exit;
		      	}
		      	else 
		        	return 'AlreadyExists';
		    }
		}

		public static function Log_user_in($data) {
			self::initialize();

			$username = strip_tags($data[0]); $password = strip_tags($data[1]);
      		$result = DatabaseHandler::MySqli_Query("SELECT username, password_hash FROM `login` WHERE username LIKE '".$username."' LIMIT 1");
	 
	    	if (mysqli_num_rows($result) > 0) {
	    		$row = mysqli_fetch_object($result);

			    if (!empty($row) && password_verify($password, $row->password_hash))
			    {
			    	$_SESSION['username'] = $username;
			        return 'LoginSuccess';
			        exit;
			    }
			    else return 'LoginFailed';
	    	}
	    	else return 'NotFoundInDatabase';
	    }
	}
?>