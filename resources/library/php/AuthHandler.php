<?php
	/**
	* AuthHandler
	**/
	class AuthHandler
	{
		private $deviceHandler;
		private $databaseHandler;

		function __construct()
		{
			require_once 'DeviceHandler.php';
			$this->deviceHandler = new DeviceHandler();

			require_once 'DatabaseHandler.php';
			$this->databaseHandler = new DatabaseHandler();
		}

		public function Check_session()
		{
    		if(!isset($_SESSION['username'])) 
			{ 
        		//$this->deviceHandler->Head_to_site('login.php');
        		header('Refresh:0; url=../../../login.php');
        		exit;
			} 
		}

		public function Check_if_logged_in() 
		{
			return isset($_SESSION['username']);
		}

		public function Sign_in($username, $password)
		{
			if ($username != '' && $password != '')
			{
	    		$result = mysql_query("SELECT username, password FROM `login` WHERE username LIKE '".$username."' LIMIT 1") or die(mysql_error()); 
	    		if (empty($result))
	    			return 'NotFoundInDatabase';

	    		$row = mysql_fetch_object($result);
	    		if(!empty($row) && md5($password) == $row->password) 
	      		{ 
	        		$_SESSION["username"] = $username;
	        		//$this->deviceHandler->Head_to_site('overview.php');
	        		header('Refresh:0; url=../../../overview.php');
	        		exit;
	      		}
	      		else
	      			return 'LoginFailed';
			}
	      	return 'SomeFieldsAreEmpty';
		}

		public function Sign_up($username, $password, $password2)
		{
			$return = 'SomeFieldsAreEmpty';
			if($password == $password2 && $username != '' && $password != '' && $password2 != '')
       		{
	        	$result = mysql_query("SELECT `id` FROM `login` WHERE username LIKE '".$username."'") or die(mysql_error());
	        	$row = mysql_num_rows($result);
	        	$password = md5($password);

	        	if($row == 0) 
	        	{
	          		$result = mysql_query("INSERT INTO login (username, password) VALUES ('".$username."', '".$password."')") or die(mysql_error());
	          		$return = (@$result) ? 'RegistrationSuccess' : 'RegistrationError';
	        	}
	        	else 
	        		$return = 'AlreadyExists';
       		}
       		return $return;
		}

		public function Sign_out()
		{
			session_destroy();
			//$this->deviceHandler->Head_to_site('index.php');
			header('Refresh:0; url=../../../index.php');
		}
	}
?>