<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php include(dirname(__FILE__)."/res/php/_today.php"); ?>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
    <?php include(dirname(__FILE__)."/res/html/mobileHtmlHead.html"); ?>
		<title>Stundenplan</title>
	</head>
	<body class="metro">
		<header>
    		<nav class="navigation-bar dark fixed-top">
      			<nav class="navigation-bar-content">
        			<a href="./index.php" class="element"><span class="icon-arrow-left-5"></span> Stundenplan<sup>online</sup></a>
      			</nav>
    		</nav>
  		</header>
        <h1><?=$string['mobile']['index']['header.heute']; ?></h1><br/>  
        <?=loadStundenplan(); ?>
  	</body>
</html>