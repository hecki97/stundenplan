<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php $root = realpath($_SERVER["DOCUMENT_ROOT"]); ?>
<?php $host = $_SERVER['SERVER_NAME']; ?>
<?php include("$root/stundenplan/res/php/_index.php"); ?>
<?php include("$root/stundenplan/res/html/htmlHead.html"); ?>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Info</title>
	</head>
	<body class="metro" style="text-align: center;">
		<header>
          <nav class="navigation-bar dark fixed-top">
            <nav class="navigation-bar-content">
                <a href="http://<?=$host; ?>/mlkvplan/mlkVPlan.php" class="element"><span class="icon-arrow-left-5"></span> Stundenplan-online<sup><?=$lang; ?></sup></a>
         
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
        <h1>Stundenplan:</h1><br/>
        <form action="index.php" method="post">
          <table align="center" border="1">
            <tr>
              <td>/</td>
              <td>Montag:</td>
              <td>Dienstag:</td>
              <td>Mittwoch:</td>
              <td>Donnerstag:</td>
              <td>Freitag:</td>
            </tr>
            <tr>
              <td>1:</td>
              <td><input name="0" type="text" size="30" maxlength="30"></td>
              <td><input name="1" type="text" size="30" maxlength="30"></td>
              <td><input name="2" type="text" size="30" maxlength="30"></td>
              <td><input name="3" type="text" size="30" maxlength="30"></td>
              <td><input name="4" type="text" size="30" maxlength="30"></td>
            </tr>
            <tr>
              <td>2:</td>
              <td><input name="5" type="text" size="30" maxlength="30"></td>
              <td><input name="6" type="text" size="30" maxlength="30"></td>
              <td><input name="7" type="text" size="30" maxlength="30"></td>
              <td><input name="8" type="text" size="30" maxlength="30"></td>
              <td><input name="9" type="text" size="30" maxlength="30"></td>
            </tr>
            <tr>
              <td>3:</td>
              <td><input name="10" type="text" size="30" maxlength="30"></td>
              <td><input name="11" type="text" size="30" maxlength="30"></td>
              <td><input name="12" type="text" size="30" maxlength="30"></td>
              <td><input name="13" type="text" size="30" maxlength="30"></td>
              <td><input name="14" type="text" size="30" maxlength="30"></td>
            </tr>
            <tr>
              <td>4:</td>
              <td><input name="15" type="text" size="30" maxlength="30"></td>
              <td><input name="16" type="text" size="30" maxlength="30"></td>
              <td><input name="17" type="text" size="30" maxlength="30"></td>
              <td><input name="18" type="text" size="30" maxlength="30"></td>
              <td><input name="19" type="text" size="30" maxlength="30"></td>
            </tr>
            <tr>
              <td>5:</td>
              <td><input name="20" type="text" size="30" maxlength="30"></td>
              <td><input name="21" type="text" size="30" maxlength="30"></td>
              <td><input name="22" type="text" size="30" maxlength="30"></td>
              <td><input name="23" type="text" size="30" maxlength="30"></td>
              <td><input name="24" type="text" size="30" maxlength="30"></td>
            </tr>
            <tr>
              <td>6:</td>
              <td><input name="25" type="text" size="30" maxlength="30"></td>
              <td><input name="26" type="text" size="30" maxlength="30"></td>
              <td><input name="27" type="text" size="30" maxlength="30"></td>
              <td><input name="28" type="text" size="30" maxlength="30"></td>
              <td><input name="29" type="text" size="30" maxlength="30"></td>
            </tr>
            <tr>
              <td>7:</td>
              <td><input name="30" type="text" size="30" maxlength="30"></td>
              <td><input name="31" type="text" size="30" maxlength="30"></td>
              <td><input name="32" type="text" size="30" maxlength="30"></td>
              <td><input name="33" type="text" size="30" maxlength="30"></td>
              <td><input name="34" type="text" size="30" maxlength="30"></td>
            </tr>
            <tr>
              <td>8:</td>
              <td><input name="35" type="text" size="30" maxlength="30"></td>
              <td><input name="36" type="text" size="30" maxlength="30"></td>
              <td><input name="37" type="text" size="30" maxlength="30"></td>
              <td><input name="38" type="text" size="30" maxlength="30"></td>
              <td><input name="39" type="text" size="30" maxlength="30"></td>
            </tr>
          </table>
          <br/><input type="submit" name="save" value="Speichern!">
        </form>

        <?php if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $array = array();
            for ($i = 0; $i < 40; $i++) { 
              if (!empty($_POST[$i]))
                array_push($array, $_POST[$i]);
              else
                array_push($array, "/");
            }
            file_put_contents("test.data", json_encode($array));

            $arArray = json_decode(file_get_contents("test.data"), true);
        ?>
        <table align="center" border="1">
          <tr>
            <td>/</td>
            <td>Montag:</td>
            <td>Dienstag:</td>
            <td>Mittwoch:</td>
            <td>Donnerstag:</td>
            <td>Freitag:</td>
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
            }
          }
        ?>
        </table>
        </ul>
  </body>
</html>