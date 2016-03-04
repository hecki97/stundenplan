<?php
  require('bootstrap.php');

  //FileLoader::Load('Resources.Library.Php.LogHandler');

  if ($_SERVER['REQUEST_METHOD'] == 'POST')
  {
    if($_POST['password'] != null && $_POST['username'] != null) {
      $result = DatabaseHandler::MySqli_Query("SELECT username, password_hash FROM `login` WHERE username LIKE '".strip_tags($_POST['username'])."' LIMIT 1");
      
      if (empty($result)) $return = 'NotFoundInDatabase';
      $row = mysqli_fetch_object($result);

      if (!empty($row) && password_verify(strip_tags($_POST['password']), $row->password_hash))
      {
        $_SESSION['username'] = $_POST["username"];
        LogHandler::Log('User logged in', 'INFO', false);
        header('Refresh:0; url=./dashboard.php?sort=index_asc');
        exit;
      }
      else
        $result = 'LoginFailed';
    }
    else
      $result = 'SomeFieldsAreEmpty';

    $div  = '<div class="popover marker-on-top bg-red fg-grayLighter page-content-popover" style="box-shadow: 7px 7px #4C0000; display: block;">';
    switch ($result) {
      case 'LoginFailed':
        //$div .= 'Username and password do not match. Please try again.';
        $div .= DIV_POPOVER_LOGIN_FAILED;
        break;
      case 'SomeFieldsAreEmpty':
        //$div .= 'Please fill the required fields (username, password).';
        $div .= DIV_POPOVER_SOME_FIELDS_ARE_EMPTY;
        break;
      case 'NotFoundInDatabase':
        //$div .= 'Username not found in Database.';
        $div .= DIV_POPOVER_NOT_FOUND_IN_DATABASE;
        break;
    }
    $div .= '</div>';
  }
?>
<!-- HTML Code -->
<!DOCTYPE html>
<html>
  <head>
    <!-- load header from header.php -->
    <?php require('header.php'); ?>
    <title><?=_('login-title'); ?></title>
  </head>
  <body>
    <!-- load navbar from navbar.php -->
    <?php require('navbar.php'); ?>
    <div class="page-content">
      <div class="page-header"><?=_('login-page-header'); ?></div>
      <div class="page-content-box content-box-shadow">
        <h3><?=_('login-page-content-box-header'); ?></h3>
        <br/>
        <form action="login.html" method="post">
          <div class="input-control text full-size" data-role="input">
            <span class="mif-user prepend-icon"></span>
            <input type="text" placeholder="<?=_('input-text-username-placeholder'); ?>" name="username">
            <button class="button helper-button clear"><span class="mif-cross"></span></button>
          </div>
          <br/>
          <div class="input-control password full-size" data-role="input">
            <span class="mif-lock prepend-icon"></span>
            <input type="password" placeholder="<?=_('input-text-password-placeholder'); ?>" name="password">
            <button class="button helper-button reveal"><span class="mif-looks"></span></button>
          </div>
          <br/><br/>
          <button class="button" type="submit"><?=_('button-login'); ?></button>
          <a class="button link" href="./registration.php"><?=_('button-registration'); ?></a>
        </form>
    </div>
    <?=@$div; ?>
  </body>
</html>