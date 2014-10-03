<?php
	include(dirname(__FILE__)."/_auth.php");
	include(dirname(__FILE__)."/_loadLangFiles.php");
	include(dirname(__FILE__)."/_getVersionScript.php");
	include(dirname(__FILE__)."/_loadStundenplan.php");

	if (!file_exists(dirname(__FILE__)."/../data/".$_SESSION['username'].".data"))
		header("Location: http://$host/stundenplan/edit.php?do=create");
?>