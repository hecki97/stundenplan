<?php
  session_start();

  require_once(dirname(__FILE__).'/resources/library/php/DatabaseHandler.php');
  $databaseHandler = new DatabaseHandler();

  if ($_SERVER['REQUEST_METHOD'] == 'POST')
  {
    if($_POST['password'] == $_POST['password2'] && $_POST['password'] != null && $_POST['password2'] != null && $_POST['username'] != null)
      $result = $databaseHandler->Create_account_if_not_exists($_POST['username'], password_hash($_POST['password'], PASSWORD_DEFAULT));

    switch (@$result) {
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
    <title><?=REGISTRATION_TITLE;?></title>
</head>
<body>
  <!-- load navbar from navbar.php -->
  <?php require(dirname(__FILE__).'/navbar.php'); ?>
  <div class="page-content">
    <div class="page-header"><?=REGISTRATION_HEADER; ?></div>
    <div class="page-content-box content-box-shadow">
      <h3><?=REGISTRATION_PAGE_CONTENT_BOX_HEADER; ?></h3>
      <form action="registration.php" method="post">
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
        <br/>
        <div class="input-control password full-size" data-role="input">
          <span class="mif-lock prepend-icon"></span>
          <input type="password" placeholder="<?=INPUT_TEXT_PASSWORD_PLACEHOLDER; ?>" name="password2">
          <button class="button helper-button reveal"><span class="mif-looks"></span></button>
        </div>
        <br/><br/>
        <button class="button" type="submit"><?=BUTTON_REGISTRATION; ?></button>
        <a class="button link" href="./login.php"><?=BUTTON_LINK_LOGIN; ?></a>
      </form>
    </div>
    <?=@$div; ?>
  </div>
</body>
</html>
