<?php
  session_start();

  $file = json_decode(file_get_contents('resources/data/'.$_SESSION["username"].'.json'), true);
  for ($key = 0; $key < count($file); $key++) { 
      $id = $file[$key]['id'];
      if ($id == $_GET['id']) break;
  }

  $table  = '<table class="table bordered striped" align="center" style="background-color: #ffffff; color: #000;">';
  $table .= '<thead><tr><th>/</th><th>Montag</th><th>Dienstag</th><th>Mittwoch</th><th>Donnerstag</th><th>Freitag</th><tr></thead>';
  $table .= '<tbody>';
  for ($y = 1; $y <= $file[$key]['height']; $y++) { 
    $table .= '<tr><th>'.$y.'</th>';
    for ($x = 1; $x <= $file[$key]['width']; $x++) {
      $placeholder = (empty($file[$key]['savedata']['x'.$x.'y'.$y])) ? '-' : $file[$key]['savedata']['x'.$x.'y'.$y];
      $value = (empty($file[$key]['savedata']['x'.$x.'y'.$y])) ? '' : $file[$key]['savedata']['x'.$x.'y'.$y];
      $table .= '<th><input class="timetable-th-input" name="x'.$x.'y'.$y.'" type="text" placeholder="'.$placeholder.'" value="'.$value.'" style="text-align: center;"/></th>';
    }
    $table .= '</tr>';
  }
  $table .= '</tbody></table>';

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (@$_POST['save']) {
      $file[$key]['name'] = $_POST['tablename'];
      $file[$key]['timestamp'] = time();
      $file[$key]['width'] = $_POST['width'];
      $file[$key]['height'] = $_POST['height'];
      if (array_key_exists('savedata', $file[$key])) unset($file[$key]['savedata']);

      $savedata_array = array();
      for ($y = 1; $y <= $file[$key]['height'] ; $y++) { 
        for ($x = 1; $x <= $file[$key]['width'] ; $x++) {
          if (empty($_POST['x'.$x.'y'.$y])) continue;
            $savedata_array['x'.$x.'y'.$y] = $_POST['x'.$x.'y'.$y];
        }
      }

      $file[$key]['savedata'] = $savedata_array;
      $fp = fopen('resources/data/'.$_SESSION['username'].'.json', 'w');
      fwrite($fp, json_encode($file, JSON_FORCE_OBJECT));
      fclose($fp);
    }
    header('Refresh:0; url=./edit.php?id='.$id);
  }
?>
<!-- HTML Code -->
<!DOCTYPE html>
<html>
  <head>
    <!-- load header from header.php -->
      <?php require(dirname(__FILE__).'/header.php'); ?>
    <title><?=$file[$key]['name']; ?></title>
  </head>
  <body>
    <!-- load navbar from navbar.php -->
    <?php require(dirname(__FILE__).'/navbar.php'); ?>

    <div class="page-content">
      <form method="post">
      <div class="page-content-box content-box-shadow">
        <div class="input-control text full-size" data-role="input">
          <span class="mif-table prepend-icon"></span>
          <input type="text" placeholder="Tablename" name="tablename" value="<?=$file[$key]['name']; ?>">
          <button class="button helper-button clear"><span class="mif-cross"></span></button>
        </div>
          Width: <input type="text" placeholder="Width" maxlength="2" size="7" min="0" step="1" name="width" value="<?=$file[$key]['width']; ?>" />
          Height: <input type="text" placeholder="Height" maxlength="2" size="7" min="0" step="1" name="height" value="<?=$file[$key]['height']; ?>" /><br/>
          <input type="submit" name="save" value="Save!" style="height: 25px; margin-top: 10px;" />
      </div>

      <!--<div class="page-header"><?//=$file[$i][0]; ?></div>-->
      <div class="table-container content-box-shadow">
        <?=$table; ?>
      </div>
      </form>
    </div>
  </body>
</html>