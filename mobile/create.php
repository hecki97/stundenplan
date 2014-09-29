<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php $host = $_SERVER['SERVER_NAME']; ?>
<?php include(dirname(__FILE__)."/res/php/_create.php"); ?>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
    <?php include(dirname(__FILE__)."/res/html/mobileHtmlHead.html"); ?>
		<title>Stundenplan</title>
    <head>
	</head>
	<body class="metro" style="text-align: center;">
		<header>
      <nav class="navigation-bar dark fixed-top">
        <nav class="navigation-bar-content">
          <a href="./index.php" class="element"><span class="icon-arrow-left-5"></span> Stundenplan<sup>online</sup></a>
        </nav>
      </nav>
    </header>
      <h1><?=$string['mobile']['index']['header.erstellen']; ?></h1><br/>
        <form action="create.php" method="post">
          <table align="center" border="1">
            <tr>
              <td>/</td>
              <td><?=$string['stundenplan']['montag']; ?></td>
              <td><?=$string['stundenplan']['dienstag']; ?></td>
              <td><?=$string['stundenplan']['mittwoch']; ?></td>
              <td><?=$string['stundenplan']['donnerstag']; ?></td>
              <td><?=$string['stundenplan']['freitag']; ?></td>
            </tr>
            <?php
              $stunde = 1;
              for($i = 0; $i < 40; $i++){
                $zeile  = "<tr>";
                $zeile .= "<td>".$stunde.":</td>";
                for ($j = 0; $j < 5; $j++) { 
                    $zeile .= "<td><input type='text' size='10' maxlength='15' name='".$i."'></td>";
                    if ($j < 4)
                      $i++;
                }
                $zeile .= "</tr>";
                $stunde++;
                echo $zeile;
              }
            ?>
          </table>
          <br/><input type="submit" name="save" value="<?=$string['global']['button.submit.speichern']; ?>">
        </form>
  </body>
</html>