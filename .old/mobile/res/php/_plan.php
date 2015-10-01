<?php
	$host = $_SERVER['SERVER_NAME'];
	include(dirname(__FILE__)."/../../../res/php/_auth.php");
	include(dirname(__FILE__)."/../../../res/php/_loadLangFiles.php");
	include(dirname(__FILE__)."/../../../res/php/_getVersionScript.php");
	include(dirname(__FILE__)."/../../../res/php/_loadStundenplan.php");

	if (!file_exists(dirname(__FILE__)."/../../../res/data/".$_SESSION['username'].".data"))
		header("Location: http://$host/stundenplan/mobile/edit.php");
?>