<!-- PHP Code -->
<?php
  require_once(dirname(__FILE__).'/lib/php/LanguageHandler.php');
  $languageHandler = new LanguageHandler();
  $lang = $languageHandler->array;
?>
<!-- HTML Code -->
<!DOCTYPE html>
<html>
<head>
    <!-- load header from header.html -->
    <?php require(dirname(__FILE__).'/header.html'); ?>
    <title>400 Bad Request</title>
</head>
<body>
  <!-- load navbar from navbar.php -->
  <?php require(dirname(__FILE__).'/navbar.php'); ?>
  <div class="page-content">
    <div class="page-header">400 Bad Request</div>
    <div class="page-content-box page-box-shadow">
      <h2>The requested page is currently not available. Please try again later</h2>
    <!-- <a class="command-button fg-black page-box-shadow" href="./login.php" style="margin-top: 75px;" type="submit"><span class="icon mif-home"></span>Zurück zum Index<small>index.php</small></a> -->
  </div>
</body>
</html>
