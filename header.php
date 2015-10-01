<?php
	//Debug
	ini_set('display_errors', 1);
  	error_reporting(E_ALL | E_STRICT);

  	$root = pathinfo($_SERVER['SCRIPT_FILENAME']);
	define ('BASE_FOLDER', basename($root['dirname']));
	define ('SITE_ROOT',    realpath(dirname(__FILE__)));
	define ('SITE_URL',    'http://'.$_SERVER['HTTP_HOST'].'/'.BASE_FOLDER);

	require(realpath(dirname(__FILE__)).'/resources/library/php/BingImageHandler.php');
	require_once(realpath(dirname(__FILE__)).'/resources/library/php/LanguageHandler.php');

	$bingImageHandler = new BingImageHandler();
  	if (!defined('LANG')) $languageHandler = new LanguageHandler();
?>
<!-- HTML Code
<!DOCTYPE html>
<html>
	<head>
	-->
		<!-- Wichtig für iOS -->
		<meta name="viewport" content="width=device-width, initial-scale=0.75" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="css/stylesheet.css" />
		<link rel="shortcut icon" href="res/icon.ico?v=2.1"/>

		<!-- Metro UI CSS 3.0 -->
		<link href="resources/library/metro-ui-css-v3.0/css/metro.css" rel="stylesheet">
		<link href="resources/library/metro-ui-css-v3.0/css/metro-schemes.css" rel="stylesheet">
		<link href="resources/library/metro-ui-css-v3.0/css/metro-icons.css" rel="stylesheet">
		<script src="resources/library/metro-ui-css-v3.0/js/jquery.js"></script>
		<script src="resources/library/metro-ui-css-v3.0/js/metro.js"></script>
	<!--
	</head>
	<body>
	</body>
</html>
-->