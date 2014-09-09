<?php
	$root = realpath($_SERVER["DOCUMENT_ROOT"]);
	include_once("$root/stundenplan/res/php/_loadLangFiles.php");

	@$verbindung = mysql_connect("localhost", "stundenplanLogin" , "") or die($string['global']['mysql.connect.error']); 
	@mysql_select_db("stundenplan", $verbindung) or die ($string['global']['mysql.select.db.error']);
?>