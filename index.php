<?php
    session_start();
    require('bootstrap.php');

    if (isset($_SESSION['username'])) header('Refresh:0; url=./dashboard.php');

    // Use .html instead of .php file extension
    $info = pathinfo($_SERVER['REQUEST_URI']);
    if (@$info['extension'] == 'php') header('Refresh:0; url=./'.str_replace('.php', '.html', basename(__FILE__)));
?>
<!-- HTML Code -->
<!DOCTYPE html>
<html>
	<head>
    	<!-- load header from header.php -->
    	<?php require('header.php'); ?>
		<title><?=INDEX_TITLE; ?></title>
	</head>
	<body>
		<!-- load navbar from navbar.php -->
		<?php require('navbar.php'); ?>
        <div class="page-content">
            <div class="page-header"><?=INDEX_PAGE_HEADER; ?></div>
            <br/>
            <img src="./img/content/background.png">
            <br/>
            <a class="command-button fg-black content-box-shadow" href="./registration.html" style="margin-right: 25px;" type="submit"><span class="icon mif-enter"></span><?=COMMAND_BUTTON_REGISTRATION; ?><small><?=COMMAND_BUTTON_REGISTRATION_SMALL; ?></small></a>
    	    <a class="command-button fg-black content-box-shadow" href="./login.html" style="margin-left: 25px;" type="submit"><span class="icon mif-key"></span><?=COMMAND_BUTTON_LOGIN; ?><small><?=COMMAND_BUTTON_LOGIN_SMALL; ?></small></a>
        </div>
    </body>
</html>