<?php
	$host = $_SERVER['SERVER_NAME'];
	include(dirname(__FILE__)."/_auth.php");
	include(dirname(__FILE__)."/../../../res/php/_loadLangFiles.php");
	include(dirname(__FILE__)."/../../../res/php/_getVersionScript.php");

	if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $array = array();
        for ($i = 0; $i < 40; $i++) { 
            if (!empty($_POST[$i]))
                array_push($array, $_POST[$i]);
            else
                array_push($array, "/");
    	}
    	file_put_contents(dirname(__FILE__)."/../../../res/data/".$_SESSION['username'].".data", json_encode($array));
     	header("Location: http://$host/stundenplan/mobile/index.php");
    }  
?>