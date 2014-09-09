<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php $root = realpath($_SERVER["DOCUMENT_ROOT"]); ?>
<?php $host = $_SERVER['SERVER_NAME']; ?>
<?php include("$root/stundenplan/res/html/htmlHead.html"); ?>
<?php include("$root/stundenplan/res/php/_loadLangFiles.php"); ?>
<?php include("$root/stundenplan/res/php/_getVersionScript.php"); ?>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Authentication failed</title>
    </head>
    <body class="metro">
        <header>
          <nav class="navigation-bar dark fixed-top">
            <nav class="navigation-bar-content">
                <button href="./index.php" class="element"><span class="icon-home"></span> Stundenplan-online<sup><?=$lang; ?></sup></button>
         
                <span class="element-divider"></span>
                <button class="element brand no-phone no-tablet" onclick="window.location.reload();"><span class="icon-spin"></span></button>
                <span class="element-divider"></span>

                <a href="./info.php" class="element brand place-right no-phone no-tablet"><span class="icon-cog"></span></a>
                <span class="element-divider place-right"></span>
                <a class="element place-right no-phone no-tablet">
                  <?=$version; ?>
                </a>
                <span class="element-divider place-right"></span>
                <a href="./login.php" class="element place-right no-phone">
                  <span class="icon-locked"></span> <?=$string['global']['menu.login']; ?>
                </a>
                <span class="element-divider place-right"></span>
            </nav>
          </nav>
        </header>

        <div class="container" style="text-align: center;">
            <h1><?=$string['authfailed']['auth.failed']; ?></h1>
            <h2><?=$string['authfailed']['relogin']; ?></h2>
            <form action="login.php">
                <input type="submit" name="zumLogin" value="<?=$string['global']['menu.login']; ?>"><br />
            </form>
        </div>
    </body>
</html>