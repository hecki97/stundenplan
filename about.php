<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<!-- load header from header.html -->
    	<?php require(dirname(__FILE__)."/res/html/header.html"); ?>
		<title>About</title>
	</head>
	<body class="metro">
		<!-- load navbar from navbar.php -->
		<?php require(dirname(__FILE__)."/navbar.php"); ?>
		<div style="margin-top: 45px;">
		<table>
		    <tr class="title"><h1><?=$lang['labels']['l.about']; ?></h1></tr>
		    <tr><h2><a href="https://github.com/hecki97/stundenplan"><?=$lang['labels']['l.source.code']; ?></h2></a></tr>
		    <br/>
		    <tr><h2><?=$lang['labels']['l.powered.by']; ?> </h2><h3><a href="http://metroui.org.ua">Metro UI CSS 2.0</a></h3>
		    <br/></tr>
		    <tr><h2><a href="./mobile/index.php"><?=$lang['labels']['l.mobile']; ?></h2></a></tr>
		    <br/>
		    <tr><h4><?=$lang['labels']['l.c']; ?></h4></tr>
		    <tr><h4><?=$lang['labels']['l.version']; ?> <?=$version; ?></h4></tr>
		</table>
		</div>
	</body>
</html>