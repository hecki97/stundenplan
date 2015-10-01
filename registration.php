<?php
  session_start();

  require_once(dirname(__FILE__).'/resources/library/php/AuthHandler.php');
  $authHandler = new AuthHandler();

  //require_once(dirname(__FILE__).'/lib/php/LanguageHandler.php');
  //$languageHandler = new LanguageHandler();

  if ($_SERVER['REQUEST_METHOD'] == 'POST')
  {
    $result = $authHandler->Sign_up($_POST['username'], $_POST['password'], $_POST['password2']);

    switch ($result) {
      case 'RegistrationSuccess':
        $div  = '<div class="popover marker-on-top bg-green fg-black" style="margin: 15px auto 0px auto; width: 300px; display: block; box-shadow: 7px 7px #003E00;">';
        $div .= $lang['labels']['l.registration.succes'].'<b>'.$_POST['username'].'</b>'.$lang['labels']['l.registration.succes.2'];
        $div .= '</div>';
        break;
      case 'RegistrationError':
        $div  = '<div class="popover marker-on-top bg-red fg-grayLighter" style="margin: 15px auto 0px auto; width: 300px; display: block; box-shadow: 7px 7px #4C0000;">';
        $div .= 'Username and passwords do not match. Please try again.';
        $div .= '</div>';
        break;
      case 'AlreadyExists':
        $div  = '<div class="popover marker-on-top bg-red fg-grayLighter" style="margin: 15px auto 0px auto; width: 300px; display: block; box-shadow: 7px 7px #4C0000;">';
        $div .= 'Username already exists. Please try again.';
        $div .= '</div>';
        break;
      default:
        $div  = '<div class="popover marker-on-top bg-red fg-grayLighter" style="margin: 15px auto 0px auto; width: 300px; display: block; box-shadow: 7px 7px #4C0000;">';
        $div .= 'Please fill the required fields (username, passwords).';
        $div .= '</div>';
        break;
    }
  }
?>
<!-- HTML Code -->
<!DOCTYPE html>
<html>
<head>
    <!-- load header from header.php -->
    <?php require(dirname(__FILE__).'/header.php'); ?>
    <title>Registrierung</title>
</head>
<body>
  <!-- load navbar from navbar.php -->
  <?php require(dirname(__FILE__).'/navbar.php'); ?>
  <div class="page-content">
    <div class="page-header"><?=$lang['labels']['l.registration']; ?></div>
    <div class="page-content-box content-box-shadow">
      <h3>Anmeldeinformationen</h3>
      <form action="registration.php" method="post">
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
        <br/>
        <div class="input-control password full-size" data-role="input">
          <span class="mif-lock prepend-icon"></span>
          <input type="password" placeholder="Re-enter your password here..." name="password2">
          <button class="button helper-button reveal"><span class="mif-looks"></span></button>
        </div>
        <br/><br/>
        <button class="button" type="submit">Registrieren!</button>
        <a class="button link" href="./login.php">Zum Login!</a>
      </form>
    </div>
    <?=@$div; ?>
  </div>
</body>
</html>
