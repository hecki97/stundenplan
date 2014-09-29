<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php $host = $_SERVER['SERVER_NAME']; ?>
<?php include(dirname(__FILE__)."/res/php/_edit.php"); ?>
<?php include(dirname(__FILE__)."/res/html/htmlHead.html"); ?>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Bearbeiten</title>
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
                <a class="element place-right no-phone no-tablet">
                  <?=$version; ?>
                </a>
                <span class="element-divider place-right"></span>
                <a class="element place-right no-phone no-tablet">
                  <span class="icon-unlocked"></span> <?=$_SESSION['username']; ?>
                </a>
                <span class="element-divider place-right"></span>
            </nav>
          </nav>
        </header>
        <h1><?=$string['global']['stundenplan']; ?></h1><br/>  
          <form action="edit.php" method="post">
            <?php $arArray = json_decode(file_get_contents(dirname(__FILE__)."/res/data/".$_SESSION['username'].".data"), true); ?>
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
                    $text = str_replace('/', '', $arArray[$i]);
                    $zeile .= "<td><input type='text' size='30' maxlength='30' name='".$i."' value='".$text."'></td>";
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
        
          <?php if ($_SERVER['REQUEST_METHOD'] == 'POST')
          {
              ?><h2><?=$string['stundenplan']['preview']; ?></h2><?php
              $array = array();
              for ($i = 0; $i < 40; $i++) { 
                if (!empty($_POST[$i]))
                  array_push($array, $_POST[$i]);
                else
                  array_push($array, "/");
              }
              file_put_contents(dirname(__FILE__)."/res/data/".$_SESSION['username'].".data", json_encode($array));

              $arArray = json_decode(file_get_contents(dirname(__FILE__)."/res/data/".$_SESSION['username'].".data"), true);
          ?>
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
                    $zeile .= "<td width='250px' height='25px'>".$arArray[$i]."</td>";
                    if ($j < 4)
                      $i++;
                }
                $zeile .= "</tr>";
                $stunde++;
                echo $zeile;
                $div_style = "block";
              }
            }
          ?>
          </table>
        <form action="">
          <br/><input type="submit" name="fback" value="<?=$string['global']['button.submit.plan']; ?>">
        </form>
  </body>
</html>