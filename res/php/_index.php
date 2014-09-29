<?php
	include(dirname(__FILE__)."/_loadLangFiles.php");
	include(dirname(__FILE__)."/_getVersionScript.php");
	include(dirname(__FILE__)."/_buttonScript.php");

	//Zum Login
	Button("blogin", "stundenplan/login.php");
	
	//Zum Register
	Button("bregister", "stundenplan/registration.php");
?>