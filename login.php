<?php
  session_start();

  require_once(realpath(dirname(__FILE__)).'/resources/library/php/DatabaseHandler.php');
  require_once(realpath(dirname(__FILE__)).'/resources/library/php/LanguageHandler.php');

  $databaseHandler = new DatabaseHandler();
  $languageHandler = new LanguageHandler();

  if ($_SERVER['REQUEST_METHOD'] == 'POST')
  {
    $result = $databaseHandler->Get_Password_Hash_from_database($_POST["username"]);
    if (password_verify($_POST['password'], $result))
    {
      $_SESSION['username'] = $_POST["username"];
      header('Refresh:0; url=./overview.php');
      exit;
    }
    else
      $result = 'LoginFailed';

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
    <?php require(realpath(dirname(__FILE__))."/header.php"); ?>
    <title><?=LOGIN_TITLE; ?></title>
  </head>
  <body>
    <!-- load navbar from navbar.php -->
    <?php require(realpath(dirname(__FILE__))."/navbar.php"); ?>
    <div class="page-content">
      <div class="page-header"><?=LOGIN_PAGE_HEADER; ?></div>
      <div class="page-content-box content-box-shadow">
        <!--<h3>Enter your credentials:</h3>-->
        <h3><?=LOGIN_PAGE_CONTENT_BOX_HEADER; ?></h3>
        <br/>
        <form action="login.php" method="post">
          <div class="input-control text full-size" data-role="input">
            <span class="mif-user prepend-icon"></span>
            <input type="text" placeholder="<?=INPUT_TEXT_USERNAME_PLACEHOLDER; ?>" name="username">
            <button class="button helper-button clear"><span class="mif-cross"></span></button>
          </div>
          <br/>
          <div class="input-control password full-size" data-role="input">
            <span class="mif-lock prepend-icon"></span>
            <input type="password" placeholder="<?=INPUT_TEXT_PASSWORD_PLACEHOLDER; ?>" name="password">
            <button class="button helper-button reveal"><span class="mif-looks"></span></button>
          </div>
          <br/><br/>
          <button class="button" type="submit"><?=BUTTON_LOGIN; ?></button>
          <a class="button link" href="./registration.php"><?=BUTTON_LINK_REGISTRATION; ?></a>
        </form>
    </div>
    <?=@$div; ?>
  </body>
</html>