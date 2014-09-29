<?php
	include(dirname(__FILE__)."/_auth.php");
	include(dirname(__FILE__)."/../../../res/php/_loadLangFiles.php");
	include(dirname(__FILE__)."/../../../res/php/_getVersionScript.php");
	include(dirname(__FILE__)."/../../../res/php/_buttonScript.php");

	if (!file_exists(dirname(__FILE__)."/../../../res/data/".$_SESSION['username'].".data"))
		header("Location: http://$host/stundenplan/mobile/create.php");
?>