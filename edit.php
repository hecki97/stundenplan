<?php
  session_start();

  require_once(dirname(__FILE__).'/resources/library/php/StundenplanHandler.php');
  $stundenplanHandler = new StundenplanHandler($_GET['id']);
  $table = $stundenplanHandler->Load_Timetable_Edit();

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (@$_POST['save']) {
      $stundenplanHandler->Save_Timetable();
    }
    //header('Refresh:0; url=./edit.php?id='.$_GET['id']);
    header('Refresh:0; url=./overview.php');
  }
?>
<!-- HTML Code -->
<!DOCTYPE html>
<html>
  <head>
    <!-- load header from header.php -->
      <?php require(dirname(__FILE__).'/header.php'); ?>
    <title><?=$stundenplanHandler->file[$stundenplanHandler->key]['name']; ?></title>
  </head>
  <body>
    <!-- load navbar from navbar.php -->
    <?php require(dirname(__FILE__).'/navbar.php'); ?>

    <div class="page-content">
      <form method="post">
        <div class="page-content-box content-box-shadow">
          <div class="input-control text full-size" data-role="input">
            <span class="mif-table prepend-icon"></span>
            <input type="text" placeholder="Tablename" name="tablename" value="<?=$stundenplanHandler->file[$stundenplanHandler->key]['name']; ?>">
            <button class="button helper-button clear"><span class="mif-cross"></span></button>
          </div>
          Width: <input type="text" placeholder="Width" maxlength="2" size="7" min="0" step="1" name="width" value="<?=$stundenplanHandler->file[$stundenplanHandler->key]['width']; ?>" />
          Height: <input type="text" placeholder="Height" maxlength="2" size="7" min="0" step="1" name="height" value="<?=$stundenplanHandler->file[$stundenplanHandler->key]['height']; ?>" /><br/>
          <input type="submit" name="save" value="Save!" style="height: 25px; margin-top: 10px;" />
          <input type="submit" name="cancel" value="Cancel!" style="height: 25px; margin-top: 10px;" />
        </div>

        <div class="table-container content-box-shadow">
          <?=$table; ?>
        </div>
      </form>
    </div>
  </body>
</html>