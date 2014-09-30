<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php $host = $_SERVER['SERVER_NAME']; ?>
<?php include(dirname(__FILE__)."/res/php/_eintragen.php"); ?>
<?php include(dirname(__FILE__)."/res/html/htmlHead.html"); ?>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Create</title>
    <head>
	</head>
	<body class="metro" style="text-align: center;">
		<header>
      <nav class="navigation-bar dark fixed-top">
        <nav class="navigation-bar-content">
          <a href="http://<?=$host; ?>/stundenplan/plan.php" class="element"><span class="icon-arrow-left-5"></span> Stundenplan-online<sup><?=$lang; ?></sup></a>
         
          <span class="element-divider"></span>
          <button class="element brand no-phone no-tablet" onclick="window.location.reload();"><span class="icon-spin"></span></button>
          <span class="element-divider"></span>

          <a href="./info.php" class="element brand place-right no-phone no-tablet"><span class="icon-cog"></span></a>
          <span class="element-divider place-right"></span>
          <a class="element place-right no-phone no-tablet"><?=$version; ?></a>
          <span class="element-divider place-right"></span>
          <a class="element place-right no-phone no-tablet"><span class="icon-unlocked"></span> <?=$_SESSION['username']; ?></a>
          <span class="element-divider place-right"></span>
        </nav>
      </nav>
    </header>
    <h1><?=$string['global']['stundenplan']; ?></h1><br/>
    <form action="eintragen.php" method="post">
      <?=loadStundenplanTextFields($wochentagArray); ?>
      <br/><input type="submit" name="save" value="<?=$string['global']['button.submit.speichern']; ?>">
    </form>
    <?=@$result; ?>
    <form action="./plan.php">
      <br/><input type="submit" value="<?=$string['global']['button.submit.plan']; ?>">
    </form>
  </body>
</html>