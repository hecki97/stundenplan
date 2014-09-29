<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php include(dirname(__FILE__)."/res/php/_info.php"); ?>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php include(dirname(__FILE__)."/res/html/mobileHtmlHead.html"); ?>
        <title>Stundenplan-online</title>
    </head>
    <body class="metro" style="text-align: center;">
    	<header>
          <nav class="navigation-bar dark fixed-top">
            <nav class="navigation-bar-content">
                <a href="./index.php" class="element"><span class="icon-arrow-left-5"></span> Stundenplan<sup>online</sup></a>
            </nav>
          </nav>
        </header>
        <nav class="vertical-menu">
            <ul>
                <li class="title"><h1><?=$string['info']['info']; ?></h1></li>
                <li><a href="https://github.com/hecki97/MLKVertretungsplan-ios-mobileapp"><h2><?=$string['info']['source.code']; ?></h2></a></li><br/>
                <li><h2><?=$string['info']['powered.by']; ?> </h2><h3><a href="http://metroui.org.ua">Metro UI CSS 2.0</a></h3><br></li>
                <li><a><?=$string['info']['c']; ?></a></li>
                <li><a><?=$string['info']['version']; ?> <?php echo $version; ?></a></li>
            </ul>
        </nav>
    </body>
</html>