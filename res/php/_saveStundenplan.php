<?php
	function saveStundenplan()
	{
		$array = array();
    	for ($i = 0; $i < 40; $i++) { 
            array_push($array, $_POST[$i]);
    	}
    	file_put_contents(dirname(__FILE__)."/../data/".$_SESSION['username'].".data", json_encode($array));	
	}
?>