<!-- PHP Code -->
<?php
  require(dirname(__FILE__).'/lib/php/AuthHandler.php');
  $authHandler = new AuthHandler();
?>
<!-- HTML Code -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php //include(dirname(__FILE__)."/res/php/_registration.php"); ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="de" lang="de">
<head>
    <!-- load header from header.html -->
    <?php require(dirname(__FILE__).'/res/html/header.html'); ?>
    <title>Registrierung</title>
</head>
<body class="metro">
  <!-- load navbar from navbar.php -->
  <?php require(dirname(__FILE__).'/navbar.php'); ?>

  <div class="container" style="margin-top: 45px;">
    <h1><?=$lang['labels']['l.registration']; ?></h1>
    <form action="registration.php" method="post">
      <h3><?=$lang['labels']['l.data']; ?></h3>
      <table cellpadding="2" align="center">
        <tr>
          <th><?=$lang['labels']['l.username']; ?></th>
          <th><input type="text" name="username" /></th>
        </tr>
        <tr>
          <th><?=$lang['labels']['l.password']; ?></th>
          <th><input type="password" name="password" /></th>
        </tr>
        <tr>
          <th><?=$lang['labels']['l.password.rep']; ?></th>
          <th><input type="password" name="password2" /></th>
        </tr>
      </table>
      <br><input type="submit" value="<?=$lang['buttons']['b.register']; ?>">
      <br/><?=@$return; ?>
    </form>
  </div>
</body>
</html>
<!-- PHP Code (Post) -->
<?php
  if ($_SERVER['REQUEST_METHOD'] == 'POST')
  {
    $result = $authHandler->Sign_up($_POST['username'], $_POST['password'], $_POST['password2']);

    switch ($result) {
      case 'RegistrationSuccess':
        $return = '<br/>'.$lang['labels']['l.registration.succes'].'<b>'.$_POST['username'].'</b>'.$lang['labels']['l.registration.succes.2'].' <a href="./login.php">'.$lang['links']['a.login'].'</a>'; 
        break;
      case 'RegistrationError':
        JavaScript_Alert($lang['javascript.alerts']['j.error']);
        break;
      case 'AlreadyExists':
        JavaScript_Alert($lang['javascript.alerts']['j.already.exists']);
        break;
      default:
        JavaScript_Alert($lang['javascript.alerts']['j.fields']);
        break;
    }
  }

  function JavaScript_Alert($message) {
    ?><script type='text/javascript'>alert("<?=$message; ?>");</script><?php
  }
?>
