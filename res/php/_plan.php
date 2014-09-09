<?php
	$root = realpath($_SERVER["DOCUMENT_ROOT"]);
	$host = $_SERVER['SERVER_NAME'];
	include("$root/stundenplan/res/php/_auth.php");
	include("$root/stundenplan/res/php/_loadLangFiles.php");
	include("$root/stundenplan/res/php/_getVersionScript.php");
	include("$root/stundenplan/res/php/_buttonScript.php");

	if (!file_exists("$root/stundenplan/res/data/".$_SESSION['username'].".data"))
		header("Location: http://$host/stundenplan/eintragen.php");

	//Bearbeiten
	Button("fedit", "stundenplan/eintragen.php");
?>