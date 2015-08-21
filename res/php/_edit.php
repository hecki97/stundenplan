<?php
	include(dirname(__FILE__)."/_auth.php");
	include(dirname(__FILE__)."/_loadLangFiles.php");
	include(dirname(__FILE__)."/_getVersionScript.php");
	include(dirname(__FILE__)."/_stundenplanClass.php");
	$stundenplan = new Stundenplan();

	if(isset($_GET['do']) && $_GET['do'] == "create")
		$stundenplan->Create();

	if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
    	if (@$_POST['save'])
    	{
    		$stundenplan->Save();
    		$result  = "<h2>".$string['labels']['l.preview']."</h2>";
        	$result .= $stundenplan->Load();
        }

        if (@$_POST['reset'])
        	$stundenplan->Create();
    }
?>