<?php
	include(dirname(__FILE__)."/_checkDataBase.php");
	include(dirname(__FILE__)."/_loadLangFiles.php");
	include(dirname(__FILE__)."/_getVersionScript.php");
	include(dirname(__FILE__)."/_buttonScript.php");

	//Zum Plan
	Button("plan", "stundenplan/index.php");
?>