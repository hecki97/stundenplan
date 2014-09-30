<?php
	include(dirname(__FILE__)."/_auth.php");
	include(dirname(__FILE__)."/_loadLangFiles.php");
	include(dirname(__FILE__)."/_getVersionScript.php");
	include(dirname(__FILE__)."/_loadStundenplan.php");
	include(dirname(__FILE__)."/_saveStundenplan.php");

	if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
    	saveStundenplan();
    	$result  = "<h2>".$string['stundenplan']['preview']."</h2>";
        $result .= loadStundenplan($wochentagArray);
    }
?>