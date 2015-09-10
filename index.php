<!-- PHP Code -->
<?php session_start(); ?>
<!-- HTML Code -->
<!DOCTYPE html>
<html>
	<head>
    	<!-- load header from header.html -->
    	<?php require(dirname(__FILE__).'/header.html'); ?>
		<title>Stundenplan</title>
	</head>
	<body>
		<!-- load navbar from navbar.php -->
		<?php require(dirname(__FILE__).'/navbar.php'); ?>
        <div class="page-content">
            <div class="page-header">Stundenplan-online<sup>de</sup> <!--<?//=$lang['labels']['l.timetable']; ?>--></div>
            <br/>
            <img src="./res/bg.png">
            <br/>
            <a class="command-button fg-black page-box-shadow" href="./registration.php" style="margin-right: 25px;" type="submit"><span class="icon mif-enter"></span>Loslegen!<small>Zur Registrierung!</small></a>
    	    <a class="command-button fg-black page-box-shadow" href="./login.php" style="margin-left: 25px;" type="submit"><span class="icon mif-key"></span>Fortsetzen!<small>Zum Login!</small></a>
        </div>
    </body>
</html>