<?php
	include(dirname(__FILE__)."/_auth.php");
	include(dirname(__FILE__)."/../../../res/php/_loadLangFiles.php");
	include(dirname(__FILE__)."/../../../res/php/_getVersionScript.php");
	include(dirname(__FILE__)."/../../../res/php/_buttonScript.php");

	if (!file_exists(dirname(__FILE__)."/../../../res/data/".$_SESSION['username'].".data"))
		header("Location: http://$host/stundenplan/mobile/create.php");

	switch (date("N")) {
		case '1':
			$tag = "Montag";
			$index = 0;
			break;
		
		case '2':
			$tag = "Dienstag";
			$index = 1;
			break;

		case '3':
			$tag = "Mittwoch";
			$index = 2;
			break;

		case '4':
			$tag = "Donnerstag";
			$index = 3;
			break;

		case '5':
			$tag = "Freitag";
			$index = 4;
			break;

		case '6':
			$tag = "Samstag";
			$index = 0;
			break;

		case '7':
			$tag = "Sonntag";
			$index = 0;
			break;

		default:
			$tag = "???";
			break;
	}
?>