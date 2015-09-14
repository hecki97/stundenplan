<!-- PHP Code -->
<?php
    session_start();
    // require_once(dirname(__FILE__).'/lib/php/LanguageHandler.php');
    // var_dump(defined('LANG'));
    // if (!defined('LANG')) $languageHandler = new LanguageHandler();
?>
<!-- HTML Code -->
<!DOCTYPE html>
<html>
	<head>
    	<!-- load header from header.html -->
    	<?php require(dirname(__FILE__).'/header.html'); ?>
		<title><?=INDEX_TITLE; ?></title>
	</head>
	<body>
		<!-- load navbar from navbar.php -->
		<?php require(dirname(__FILE__).'/navbar.php'); ?>
        <div class="page-content">
            <div class="page-header"><?=INDEX_PAGE_HEADER; ?></div>
            <br/>
            <img src="./res/bg.png">
            <br/>
            <a class="command-button fg-black page-box-shadow" href="./registration.php" style="margin-right: 25px;" type="submit"><span class="icon mif-enter"></span><?=COMMAND_BUTTON_REGISTRATION; ?><small><?=COMMAND_BUTTON_REGISTRATION_SMALL; ?></small></a>
    	    <a class="command-button fg-black page-box-shadow" href="./login.php" style="margin-left: 25px;" type="submit"><span class="icon mif-key"></span><?=COMMAND_BUTTON_LOGIN; ?><small><?=COMMAND_BUTTON_LOGIN_SMALL; ?></small></a>
        </div>
    </body>
</html>