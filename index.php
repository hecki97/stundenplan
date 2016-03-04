<?php
    require('bootstrap.php');

    if (isset($_SESSION['username'])) header('Refresh:0; url=./dashboard.php');
?>
<!-- HTML Code -->
<!DOCTYPE html>
<html>
	<head>
    	<!-- load header from header.php -->
    	<?php require('header.php'); ?>
		<title><?=_('index-title'); ?></title>
	</head>
	<body>
		<!-- load navbar from navbar.php -->
		<?php require('navbar.php'); ?>
        <div class="page-content">
            <div class="page-header"><?=_('index-page-header'); ?></div>
            <br/>
            <img src="./img/content/background.png">
            <br/>
            <a class="command-button fg-black content-box-shadow" href="./registration.html" style="margin-right: 25px;" type="submit"><span class="icon mif-enter"></span><?=_('command-button-registration'); ?><small><?=_('command-button-registration-sub-text'); ?></small></a>
    	    <a class="command-button fg-black content-box-shadow" href="./login.html" style="margin-left: 25px;" type="submit"><span class="icon mif-key"></span><?=_('command-button-login'); ?><small><?=_('command-button-login-sub-text'); ?></small></a>
        </div>
    </body>
</html>