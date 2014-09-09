<?php
	$root = realpath($_SERVER["DOCUMENT_ROOT"]);

	include("$root/stundenplan/res/php/_checkDataBase.php");
	include("$root/stundenplan/res/php/_loadLangFiles.php");
	include("$root/stundenplan/res/php/_getVersionScript.php");
	include("$root/stundenplan/res/php/_buttonScript.php");

	//Zum Plan
	Button("plan", "stundenplan/plan.php");
?>