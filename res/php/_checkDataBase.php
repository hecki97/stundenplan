<?php
	include_once(dirname(__FILE__)."/_loadLangFiles.php");

	@$verbindung = mysql_connect("localhost", "stundenplanLogin" , "") or die($string['mysql']['m.connect.error']); 
	@mysql_select_db("stundenplan", $verbindung) or die ($string['mysql']['m.select.db.error']);

	//Config
	$table = "login";
?>