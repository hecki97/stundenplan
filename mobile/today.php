<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php $host = $_SERVER['SERVER_NAME']; ?>
<?php include(dirname(__FILE__)."/res/php/_today.php"); ?>
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
        <h1><?=$string['mobile']['index']['header.heute']; ?></h1><br/>  
          <?php $arArray = json_decode(file_get_contents(dirname(__FILE__)."/../res/data/".$_SESSION['username'].".data"), true); ?>
          <table align="center" border="1">
            <tr>
              <td>/</td>
              <td><?=$tag; ?></td>
            </tr>
          <?php
              $stunde = 1;
              for($i = 0; $i < 8; $i++){
                $zeile  = "<tr>";
                $zeile .= "<td>".$stunde.":</td>";
                for ($j = 0; $j < 1; $j++) { 
                    if (date("N") < 6)
                      $zeile .= "<td width='300px' height='35px' font-size='45px'>".$arArray[$index]."</td>";
                    else
                      $zeile .= "<td width='300px' height='35px' font-size='45px'>/</td>";
                }
                $zeile .= "</tr>";
                $stunde++;
                $index += 5;
                echo $zeile;
              }
          ?>
          </table>
  </body>
</html>