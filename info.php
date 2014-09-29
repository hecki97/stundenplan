<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php $host = $_SERVER['SERVER_NAME']; ?>
<?php include(dirname(__FILE__)."/res/html/htmlHead.html"); ?>
<?php include(dirname(__FILE__)."/res/php/_info.php"); ?>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Info</title>
	</head>
	<body class="metro" style="text-align: center;">
		<header>
          <nav class="navigation-bar dark fixed-top">
            <nav class="navigation-bar-content">
                <a href="http://<?=$host; ?>/stundenplan/plan.php" class="element"><span class="icon-arrow-left-5"></span> Stundenplan-online<sup><?=$lang; ?></sup></a>
         
                <span class="element-divider"></span>
                <button class="element brand no-phone no-tablet" onclick="window.location.reload();"><span class="icon-spin"></span></button>
                <span class="element-divider"></span>

                <a class="element brand place-right no-phone no-tablet"><span class="icon-cog"></span></a>
                <span class="element-divider place-right"></span>
                <a class="element place-right no-phone no-tablet">
                  <?=$version; ?>
                </a>
                <span class="element-divider place-right"></span>
                <a href="./login.php" class="element place-right no-phone no-tablet">
                  <span class="icon-key"></span> <?=$string['global']['menu.login']; ?>
                </a>
                <span class="element-divider place-right"></span>
            </nav>
          </nav>
        </header>
		<nav class="vertical-menu">
		    <ul>
		        <li class="title"><h1><?=$string['info']['info']; ?></h1></li>
		        <li><a href="https://github.com/hecki97/stundenplan"><h2><?=$string['info']['source.code']; ?></h2></a></li><br/>
		        <li><h2><?=$string['info']['website']; ?></h2><h3><a href="http://www.mlk-vk.de">www.mlk-vk.de</a></h3></li><br/>
		        <li><h2><?=$string['info']['powered.by']; ?> </h2><h3><a href="http://metroui.org.ua">Metro UI CSS 2.0</a></h3><br></li>
		        <li><a><?=$string['info']['c']; ?></a></li>
		        <li><a><?=$string['info']['version']; ?> <?php echo $version; ?></a></li>
		    </ul>
		</nav>
		<form action="info.php" method="post">
			<input type="submit" name="fback" value="<?=$string['global']['button.submit.plan']; ?>" />
		</form>
	</body>
</html>