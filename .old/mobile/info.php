<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php include(dirname(__FILE__)."/../res/php/_getVersionScript.php"); ?>
<?php include(dirname(__FILE__)."/../res/php/_loadLangFiles.php"); ?>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php include(dirname(__FILE__)."/res/html/mobileHtmlHead.html"); ?>
		<title>Info</title>
	</head>
	<body class="metro">
		<header>
          <nav class="navigation-bar dark fixed-top">
            <nav class="navigation-bar-content">
                <a href="./index.php" class="element"><span class="icon-arrow-left-5"></span> <?=$string['links']['a.timetable']; ?><sup>online</sup></a>
            </nav>
          </nav>
        </header>
		<table>
		    <tr class="title"><h1><?=$string['labels']['l.info']; ?></h1></tr>
		    <tr><a href="https://github.com/hecki97/stundenplan"><h2><?=$string['labels']['l.source.code']; ?></h2></a></tr><br/>
		    <tr><h2><?=$string['labels']['l.powered.by']; ?> </h2><h3><a href="http://metroui.org.ua">Metro UI CSS 2.0</a></h3><br/></tr>
		    <tr><a href="./../index.php"><h2><?=$string['labels']['l.desktop']; ?></h2></a></tr><br/>
            <tr><h3><?=$string['labels']['l.c']; ?></h3></tr>
		    <tr><h3><?=$string['labels']['l.version']; ?> <?php echo $version; ?></h3></tr>
		</table>
	</body>
</html>