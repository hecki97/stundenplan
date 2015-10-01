<?php
  session_start();

  require_once(realpath(dirname(__FILE__))."/resources/library/php/AuthHandler.php");
  $authHandler = new AuthHandler();
  $authHandler->Check_session();

  $file = file_exists('resources/data/'.$_SESSION["username"].'.json') ? json_decode(file_get_contents('resources/data/'.$_SESSION["username"].'.json'), true) : array();
  $div_display = empty($file) ? 'display: none;' : 'display: block;';
  $div_popover_display = 'display: none;';

  $table = "";
  for ($i = 0; $i < count($file); $i++) { 
    $table .= "<tr><th style='width: 0px;'>".($i + 1).".</th>";
    $table .= "<th><a class='button link full-size fg-black' href='./timetable.php?id=".$file[$i]['id']."' style='display: inline; font-size: 20px;'>".$file[$i]['name']."</a></th>";
    $table .= "<th style='text-align: right; width: 0px;'><i>(".date('d/m/y', $file[$i]['timestamp']).")</i></th>";
    $table .= "<th style='text-align: right; width: 125px;'><a class='button' href='./edit.php?id=".$file[$i]['id']."'><span class='mif-pencil'></span></a><a class='button' href='./resources/php/remove_from_list.php?id=".$file[$i]['id']."'><span class='mif-bin'></span></a></th></tr>";
  }

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['table'])) {
      $fp = fopen('resources/data/'.$_SESSION["username"].'.json', 'w');
      $array = array();
      $array['name'] = $_POST['table'];
      $array['id'] = uniqid();
      $array['timestamp'] = time();
      $array['width'] = 5;
      $array['height'] = 8;
      
      $new_array[0] = $array;
      for ($i = 0; $i < count($file); $i++) { 
        $new_array[$i+1] = $file[$i];
      }

      fwrite($fp, json_encode($new_array, JSON_FORCE_OBJECT));
      fclose($fp);
      header('Refresh:0; url=./overview.php');
    }
    else
      $div_popover_display = 'display: block;';
  }
?>
<!-- HTML Code -->
<!DOCTYPE html>
<html>
  <head>
    <!-- load header from header.php -->
    <?php require(dirname(__FILE__)."/header.php"); ?>
    <title>Overview</title>
  </head>
  <body>
    <!-- load navbar from navbar.php -->
    <?php require(dirname(__FILE__)."/navbar.php"); ?>
    <div class="page-content" style="max-height: 100%;">
      <div class="page-header">Übersicht</div>
      <div class="page-content-box content-box-shadow">
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
      <div class="popover marker-on-top bg-red fg-grayLighter page-content-popover" style="box-shadow: 7px 7px #4C0000; <?=$div_popover_display; ?>">
        Textfield cannot be empty. Please try again.
      </div>
      <div class="page-content-box content-box-shadow" style="overflow: auto; margin: 25px 125px 0px 125px; transform: scale(0.85); <?=$div_display; ?>">
      <table class="table border striped" align="center" style="background-color: #ffffff; color: #000;">
        <tbody>
          <?=$table; ?>
        </tbody>
      </table>
      </div>
    </div>
  </body>
</html>