<!-- PHP Code -->
<?php
  require(dirname(__FILE__)."/res/php/AuthHandler.php");
  $authHandler = new AuthHandler();

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $authHandler->Sign_in($_POST["username"], $_POST["password"]);
  }
?>
<!-- HTML Code -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="de" lang="de">
  <head>
    <!-- load header from header.html -->
    <?php require(dirname(__FILE__)."/res/html/header.html"); ?>
    <title>Login</title>
  </head>
  <body class="metro">
    <!-- load navbar from navbar.php -->
    <?php require(dirname(__FILE__)."/res/php/navbar.php"); ?>

    <div class="container">
      <h1><?=$string['labels']['l.login']; ?></h1>
      <form action="login.php" method="post" style="display: inline;">
        <table cellpadding="2" align="center">
          <tr>
            <th><?=$string['labels']['l.username']; ?></th>
            <th><input type="text" name="username" /></th>
          </tr>
          <tr>
            <th><?=$string['labels']['l.password']; ?></th>
            <th><input type="password" name="password" /></th>
          </tr>
        </table>
        <br/><input type="submit" value="<?=$string['buttons']['b.login']; ?>" />
      </form>
      <form action="./registration.php" style="display: inline;"><input type="submit" name="register" value="<?=$string['buttons']['b.register']; ?>" /></form>
    </div>
  </body>
</html>