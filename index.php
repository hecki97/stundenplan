<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php $root = realpath($_SERVER["DOCUMENT_ROOT"]); ?>
<?php $host = $_SERVER['SERVER_NAME']; ?>
<?php include("$root/stundenplan/res/html/htmlHead.html"); ?>
<?php include("$root/stundenplan/res/php/_info.php"); ?>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Index</title>
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
		<table text-align="center">
			<tr>
				
			</tr>
			<tr>
				<h1>Für mobilen Zugriff!</h1>
				<h2>Immer und überall!</h2>
				<h3>|</h3>
			</tr>
			<tr>
				<form action="login.php" method="post">
					<input type="submit" value="<?=$string['login']['button.submit.anmelden']; ?>" />
					<br/><input type="submit" value="<?=$string['login']['button.submit.registrieren']; ?>" />
				</form>
			</tr>
		</table>
	</body>
</html>