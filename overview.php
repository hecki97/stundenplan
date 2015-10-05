<?php
  session_start();

  require_once(dirname(__FILE__).'/resources/library/php/DatabaseHandler.php');
  $databaseHandler = new DatabaseHandler();
  require_once(dirname(__FILE__).'/resources/library/php/CryptHandler.php');
  $cryptHandler = new CryptHandler();

  if(!isset($_SESSION['username'])) 
  { 
    header('Refresh:0; url=./login.php');
    exit;
  } 

  if (!file_exists('resources/data/'.$_SESSION['username'].'.dat')) {
    $decrypted_file = array();
  }
  else
  {
    $file = file_get_contents('resources/data/'.$_SESSION['username'].'.dat');
    $cryptHandler->setKey($databaseHandler->Get_Encryption_Key_from_database());
    $decrypted_file = $cryptHandler->decrypt($file);
  }

  $div_display = empty($decrypted_file) ? 'display: none;' : 'display: block;';
  $div_popover_display = 'display: none;';

  $table = "";
  for ($i = 0; $i < count($decrypted_file); $i++) { 
    $table .= "<tr><th style='width: 0px;'>".($i + 1).".</th>";
    $table .= "<th><a class='button link full-size fg-black' href='./timetable.php?id=".$decrypted_file[$i]['id']."' style='display: inline; font-size: 20px;'>".$decrypted_file[$i]['name']."</a></th>";
    $table .= "<th style='text-align: right; width: 0px;'><i>(".date('d/m/y', $decrypted_file[$i]['timestamp']).")</i></th>";
    $table .= "<th style='text-align: right; width: 125px;'><a class='button' href='./edit.php?id=".$decrypted_file[$i]['id']."'><span class='mif-pencil'></span></a><a class='button' href='./resources/php/remove_from_list.php?id=".$decrypted_file[$i]['id']."'><span class='mif-bin'></span></a></th></tr>";
  }

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['table'])) {
      $fp = fopen('resources/data/'.$_SESSION["username"].'.dat', 'w');
      $array = array();
      $array['name'] = $_POST['table'];
      $array['id'] = uniqid();
      $array['timestamp'] = time();
      $array['width'] = 5;
      $array['height'] = 8;
      
      $new_array[0] = $array;
      for ($i = 0; $i < count($decrypted_file); $i++) { 
        $new_array[$i+1] = $decrypted_file[$i];
      }
      $key = $databaseHandler->Generate_Encryption_Key();
      $cryptHandler->setKey($key);
      $encrypted_file = $cryptHandler->encrypt($new_array);
      fwrite($fp, $encrypted_file);
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
    <title><?=OVERVIEW_TITLE; ?></title>
  </head>
  <body>
    <!-- load navbar from navbar.php -->
    <?php require(dirname(__FILE__)."/navbar.php"); ?>
    <div class="page-content" style="max-height: 100%;">
      <div class="page-header"><?=OVERVIEW_PAGE_HEADER; ?></div>
      <div class="page-content-box content-box-shadow">
      <form method="post">
        <div class="input-control text full-size" data-role="input">
          <span class="mif-table prepend-icon"></span>
          <input type="text" placeholder="<?=INPUT_TEXT_TIMETABLE_PLACEHOLDER; ?>" name="table">
          <div class="button-group">
            <button class="button helper-button clear"><span class="mif-cross"></span></button>
            <button class="button" name="create" type="submit"><?=BUTTON_CREATE; ?></button>
          </div> 
        </div>
      </form>
      </div>
      <div class="popover marker-on-top bg-red fg-grayLighter page-content-popover" style="box-shadow: 7px 7px #4C0000; <?=$div_popover_display; ?>">
        <?=DIV_POPOVER_TEXTFIELD_CANNOT_BE_EMPTY; ?>
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