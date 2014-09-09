<?php
	$versionFile = @fopen("https://dl.dropboxusercontent.com/u/107727443/stundenplanVersion.txt", "r");
		
	if ($versionFile != null)
		$version = fgets($versionFile);
	else
		$version = "???";	
?>