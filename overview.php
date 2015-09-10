<!-- PHP Code -->
<?php
  session_start();

  require_once(dirname(__FILE__)."/lib/php/AuthHandler.php");
  $authHandler = new AuthHandler();

  $authHandler->Check_session();

  $file = file_exists('test.json') ? json_decode(file_get_contents('test.json'), true) : array();
  $display = empty($file) ? 'display: none;' : 'display: block;';

  $result = "";
  for ($i = 0; $i < count($file); $i++) { 
    $result .= "<tr><th style='width: 25px;'>".($i + 1).".</th>";
    $result .= "<th><a class='button link full-size fg-black' href='./timetable.php?id=".$file[$i][1]."' style='display: inline; font-size: 20px;'>".$file[$i][0]."</a></th>";
    $result .= "<th style='text-align: right; width: 125px;'><a class='button'><span class='mif-pencil'></span></a><a class='button' href='./php/remove_from_list.php?id=".$file[$i][1]."'><span class='mif-bin'></span></a></th></tr>";
  }

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST["table"])) {
      $fp = fopen('test.json', 'w+');
      $array = array();
      array_push($array, $_POST['table']);
      array_push($array, uniqid());
      $file[] = $array;
      fwrite($fp, json_encode($file, JSON_FORCE_OBJECT));
      fclose($fp);
      header('Refresh:0; url=./overview.php');
    }
    else
      print_r('Textfield cannot be empty. Please try again.');
  }
?>
<!-- HTML Code -->
<!DOCTYPE html>
<html>
  <head>
    <!-- load header from header.html -->
    <?php require(dirname(__FILE__)."/header.html"); ?>
    <title>Overview</title>
  </head>
  <body style="overflow: auto;">
    <!-- load navbar from navbar.php -->
    <?php require(dirname(__FILE__)."/navbar.php"); ?>
    <div class="page-content" style="max-height: 100%;">
      <div class="page-header">Übersicht</div>
      <div class="page-content-box page-box-shadow">
      <form method="post">
        <div class="input-control text full-size" data-role="input">
          <span class="mif-table prepend-icon"></span>
          <input type="text" placeholder="Create new timetable..." name="table">
          <div class="button-group">
            <button class="button helper-button clear"><span class="mif-cross"></span></button>
            <button class="button" name="create" type="submit">Create</button>
          </div> 
        </div>
      </form>
      </div>
      <br/>
      <div class="page-content-box page-box-shadow" style="overflow: auto; margin: 25px 125px 0px 125px; <?=$display; ?>">
      <table class="table border striped" align="center" style="background-color: #ffffff; color: #000;">
        <tbody>
          <?=$result; ?>
        </tbody>
      </table>
      </div>
    </div>
  </body>
</html>