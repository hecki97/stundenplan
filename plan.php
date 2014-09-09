<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php $root = realpath($_SERVER["DOCUMENT_ROOT"]); ?>
<?php $host = $_SERVER['SERVER_NAME']; ?>
<?php include("$root/stundenplan/res/php/_plan.php"); ?>
<?php include("$root/stundenplan/res/html/htmlHead.html"); ?>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Stundenplan</title>
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
        <h1>Stundenplan:</h1><br/>  
          <?php $arArray = json_decode(file_get_contents("$root/stundenplan/res/data/".$_SESSION['username'].".data"), true); ?>
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
                    $zeile .= "<td width='300px' height='35px' font-size='25px'>".$arArray[$i]."</td>";
                    if ($j < 4)
                      $i++;
                }
                $zeile .= "</tr>";
                $stunde++;
                echo $zeile;
              }
          ?>
          </table>
          </div>
        <form>
          <br/><input type="submit" name="fedit" value="<?=$string['global']['button.submit.edit']; ?>">
        </form>
        <form action=<?="http://$host/stundenplan/res/php/_logout.php"; ?> method="post">
          <script>
            function show_confirm_logout()
            {
                return confirm("<?=$string['plan']['javascript.confirm.logout']; ?>");
            }
          </script>
          <input type="submit" onclick="return show_confirm_logout();" value="<?=$string['plan']['button.submit.logout']; ?>">
        </form>
  </body>
</html>