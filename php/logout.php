<?php
	session_start();
	
	require_once(dirname(__FILE__).'/../lib/php/DeviceHandler.php');
  	$deviceHandler = new DeviceHandler();

	session_destroy();
	$deviceHandler->Head_to_site('index.php');
?>