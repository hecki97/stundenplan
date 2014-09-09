<?php
	function Button($buttonName, $filePath)
	{
		$host = $_SERVER['SERVER_NAME'];
		
		if(isset($_REQUEST[$buttonName]))
			header("Location: http://$host/$filePath");
	}
?>