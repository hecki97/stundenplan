<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php include(dirname(__FILE__)."/res/php/_plan.php"); ?>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
    <?php include(dirname(__FILE__)."/res/html/htmlHead.html"); ?>
		<title>Stundenplan</title>
    <script type="text/javascript">
      function show_confirm_logout()
      {
        return confirm("<?=$string['plan']['javascript.confirm.logout']; ?>");
      }
      </script>
	</head>
	<body class="metro">
		<header>
      <nav class="navigation-bar dark fixed-top">
        <nav class="navigation-bar-content">
          <form action="./res/php/_logout.php" method="post"><button onclick="return show_confirm_logout();" class="element"><span class="icon-switch"></span> Stundenplan-online<sup><?=$lang; ?></sup></button></form>
         
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
    <?=loadStundenplan($wochentagArray); ?>  
    <br/><form action="./edit.php" style="display: inline;"><input type="submit" name="fedit" value="<?=$string['global']['button.submit.edit']; ?>"></form>
    <form action="./create.php" style="display: inline;"><input type="submit" name="fnew" value="<?=$string['global']['button.submit.create']; ?>"></form>
  </body>
</html>