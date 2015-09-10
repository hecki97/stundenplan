<!-- PHP Code -->
<?php
  session_start();

  require_once(dirname(__FILE__).'/lib/php/AuthHandler.php');
  $authHandler = new AuthHandler();

  require_once(dirname(__FILE__).'/lib/php/LanguageHandler.php');
  $languageHandler = new LanguageHandler();
  $lang = $languageHandler->array;

  if ($_SERVER['REQUEST_METHOD'] == 'POST')
  {
    $result = $authHandler->Sign_in($_POST["username"], $_POST["password"]);

    $div  = '<div class="popover marker-on-top bg-red fg-grayLighter page-content-popover" style="box-shadow: 7px 7px #4C0000; display: block;">';
    switch ($result) {
      case 'LoginFailed':
        $div .= 'Username and password do not match. Please try again.';
        break;
      case 'SomeFieldsAreEmpty':
        $div .= 'Please fill the required fields (username, password).';
        break;
      case 'NotFoundInDatabase':
        $div .= 'Username not found in Database.';
        break;
    }
    $div .= '</div>';
  }
?>
<!-- HTML Code -->
<!DOCTYPE html>
<html>
  <head>
    <!-- load header from header.html -->
    <?php require(dirname(__FILE__)."/header.html"); ?>
    <title>Login</title>
  </head>
  <body>
    <!-- load navbar from navbar.php -->
    <?php require(dirname(__FILE__)."/navbar.php"); ?>
    <div class="page-content">
      <div class="page-header"><?=$lang['labels']['l.login']; ?></div>
      <div class="page-content-box page-box-shadow">
        <h3>Enter your credentials:</h3>
        <br/>
        <form action="login.php" method="post">
          <div class="input-control text full-size" data-role="input">
            <span class="mif-user prepend-icon"></span>
            <input type="text" placeholder="Enter your username here..." name="username">
            <button class="button helper-button clear"><span class="mif-cross"></span></button>
          </div>
          <br/>
          <div class="input-control password full-size" data-role="input">
            <span class="mif-lock prepend-icon"></span>
            <input type="password" placeholder="Enter your password here..." name="password">
            <button class="button helper-button reveal"><span class="mif-looks"></span></button>
          </div>
          <br/><br/>
          <button class="button" type="submit">Login!</button>
          <a class="button link" href="./registration.php">Zur Registrierung!</a>
        </form>
    </div>
    <?=@$div; ?>
  </body>
</html>