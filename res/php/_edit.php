<?php
	include(dirname(__FILE__)."/_auth.php");
	include(dirname(__FILE__)."/_loadLangFiles.php");
	include(dirname(__FILE__)."/_getVersionScript.php");
	include(dirname(__FILE__)."/_loadStundenplan.php");
	include(dirname(__FILE__)."/_saveStundenplan.php");

	function CreateTable()
	{
		$array = array();
	    for ($i = 0; $i < 40; $i++)
	    {
	        array_push($array, "");
	    }
	    file_put_contents(dirname(__FILE__)."/../data/".$_SESSION['username'].".data", json_encode($array));
	}

	if(isset($_GET['do']) && $_GET['do'] == "create")
	{
		CreateTable();
	}

	if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
    	if (@$_POST['save'])
    	{
    		saveStundenplan();
    		$result  = "<h2>".$string['labels']['l.preview']."</h2>";
        	$result .= loadStundenplan($wochentagArray);
        }

        if (@$_POST['reset'])
        {
			CreateTable();
		}
    }
?>