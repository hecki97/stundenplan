<?php
	$root = realpath($_SERVER["DOCUMENT_ROOT"]);
	include("$root/stundenplan/res/php/_loadLangFiles.php");

	/*if ($_SERVER['REQUEST_METHOD'] == 'POST')
	{
		$array = array();
		for ($i = 0; $i < 10; $i++) { 
			array_push($array, $_POST["$i"]);
		}
		print_r($array);
	}*/
?>