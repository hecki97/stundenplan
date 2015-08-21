<?php
	include_once(dirname(__FILE__)."/_loadLangFiles.php");
	$db = json_decode(file_get_contents(dirname(__FILE__)."/../config/database.config"), true);

	@$verbindung = mysql_connect($db['db.config']['connection'], $db['db.config']['login'] , $db['db.config']['pw']) or die($string['mysql']['m.connect.error']); 
	@mysql_select_db($db['db.config']['database'], $verbindung) or die ($string['mysql']['m.select.db.error']);

	function LoadFromDB($_db, $_fetch)
	{
		$result = mysql_query("SELECT * FROM `".$_db."`");

		if ($_fetch)
			return mysql_fetch_object($result);
		else
			return mysql_num_rows($result);
	}
?>