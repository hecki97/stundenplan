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
			require 'DeviceHandler.php';
			$this->deviceHandler = new DeviceHandler();

			require 'DatabaseHandler.php';
			$this->databaseHandler = new DatabaseHandler();

			session_start();
			//$this->Check_session();
		}

		public function Check_session()
		{
    		if(!isset($_SESSION['username'])) 
			{ 
        		$this->deviceHandler->Head_to_site('login.php');
        		exit;
			} 
		}

		public function Check_if_logged_in() 
		{
			return isset($_SESSION['username']);
		}

		public function Sign_in($username, $password)
		{
			if (!empty($username) && !empty($password))
	    	{
	    		$request = "SELECT username, password FROM `".$db['t.login']."` WHERE username LIKE '".$username."' LIMIT 1"; 
	    		$result = mysql_query($request); 
	    		$row = mysql_fetch_object($result);

	      		if($password == $row->password) 
	      		{ 
	        		$_SESSION["username"] = $username;
	        		$this->deviceHandler->Head_to_site('index.php');
	      		} 
	      		else 
	      		{ 
	        		//<script type="text/javascript">alert("<?=//$string['javascript.alerts']['j.login.failed']; ");</script>
	        		?><script type="text/javascript">alert("Login failed!");</script><?php
	      		}
	    	}
	    	else
	    	{
	      		?><script type="text/javascript">alert("<?=$string['javascript.alerts']['j.fields']; ?>");</script><?php
	    	}
		}

		public function Sign_up($username, $password, $password2)
		{
			$return = 'SomeFieldsAreEmpty';
			if($password == $password2 && $username != '' && $password != '' && $password2 != '')
       		{
	        	$result = mysql_query("SELECT `index` FROM `login` WHERE username LIKE '$username'");
	        	$row = mysql_num_rows($result);
	        	$password = md5($password);
	        	if($row == 0) 
	        	{
	          		$query = "INSERT INTO login (username, password) VALUES ('$username', '$password')";
	          		$result = mysql_query($query);
	          		$return = (@$result) ? 'RegistrationSuccess' : 'RegistrationError';
	        	}
	        	else 
	        		$return = 'AlreadyExists';
       		}
       		return $return;
		}

		public function Log_out()
		{
			session_destroy();
			$this->deviceHandler->Head_to_site('index.php');
		}
	}
?>