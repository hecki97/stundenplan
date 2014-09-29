<?php
	include(dirname(__FILE__)."/_auth.php");
	include(dirname(__FILE__)."/../../../res/php/_checkDataBase.php");
	include(dirname(__FILE__)."/../../../res/php/_loadLangFiles.php");
	include(dirname(__FILE__)."/../../../res/php/_getVersionScript.php");
	include(dirname(__FILE__)."/../../../res/php/_buttonScript.php");

	switch (date("N")) {
		case '1':
			$tag = "Montag";
			break;
		
		case '2':
			$tag = "Dienstag";
			break;

		case '3':
			$tag = "Mittwoch";
			break;

		case '4':
			$tag = "Donnerstag";
			break;

		case '5':
			$tag = "Freitag";
			break;

		case '6':
			$tag = "Samstag";
			break;

		case '7':
			$tag = "Sonntag";
			break;

		default:
			$tag = "???";
			break;
	}
?>