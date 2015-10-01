<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php include(dirname(__FILE__)."/res/php/_edit.php"); ?>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php include(dirname(__FILE__)."/res/html/mobileHtmlHead.html"); ?>
    <title>Bearbeiten</title>
    <script type="text/javascript">
      function show_confirm_reset()
      {
        return confirm("<?=$string['javascript.alerts']['j.reset']; ?>");
      }
    </script>
	</head>
	<body class="metro">
		<header>
      <nav class="navigation-bar dark fixed-top">
        <nav class="navigation-bar-content">
          <a href="./index.php" class="element"><span class="icon-arrow-left-5"></span> <?=$string['links']['a.timetable']; ?><sup>online</sup></a>
        </nav>
      </nav>
    </header>
      <h1><?=$string['labels']['l.edit']; ?></h1><br/>  
      <form action="edit.php" method="post">
        <?=loadEditableStundenplan($wochentagArray); ?>
        <br/><input type="submit" name="save" value="<?=$string['buttons']['b.save']; ?>">
        <input type="submit" name="reset" value="<?=$string['buttons']['b.reset']; ?>" onclick="return show_confirm_reset();">
      </form>
      <?=@$result; ?>
  </body>
</html>