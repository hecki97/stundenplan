<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php include(dirname(__FILE__)."/res/php/_register.php"); ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="de" lang="de">
<head>
    <?php include(dirname(__FILE__)."/res/html/mobileHtmlHead.html"); ?>
    <title>Registrierung</title>
</head>
<body class="metro">
  <header>
    <nav class="navigation-bar dark fixed-top">
      <nav class="navigation-bar-content" style="text-align: center;">
        <form action="./login.php"><button class="element"><span class="icon-arrow-left-5"></span> Stundenplan<sup>online</sup></button></form>
      </nav>
    </nav>
  </header>

<div class="container" style="text-align: center;">
  <h1><?=$string['register']['registrierung']; ?></h1>
    <form action="register.php" method="post">
      <h3><?=$string['register']['daten']; ?></h3>
      <table cellpadding="2" align="center">
        <tr>
          <th><?=$string['register']['username']; ?></th>
          <th><input type="text" name="username" /></th>
        </tr>
        <tr>
          <th><?=$string['register']['password']; ?></th>
          <th><input type="password" name="passwort" /></th>
        </tr>
        <tr>
          <th><?=$string['register']['password.wdh']; ?></th>
          <th><input type="password" name="passwort2" /></th>
        </tr>
      </table>
      <br><input type="submit" value="<?=$string['global']['button.submit.register']; ?>">
      <br/><?=@$return; ?>
    </form>
  </div>
</body>
</html>