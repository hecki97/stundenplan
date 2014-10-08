<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php include(dirname(__FILE__)."/res/php/_login.php"); ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="de" lang="de">
 <head>
    <?php include(dirname(__FILE__)."/res/html/mobileHtmlHead.html"); ?>
    <title>Login</title>
 </head>
  <body class="metro">
  <header>
    <nav class="navigation-bar dark fixed-top">
      <nav class="navigation-bar-content" style="text-align: center;">
        <a class="element"><span class="icon-home"></span> <?=$string['links']['a.timetable']; ?><sup>online</sup></a>
      </nav>
    </nav>
  </header>

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
    <form action="./register.php" style="display: inline;"><input type="submit" name="register" value="<?=$string['buttons']['b.register']; ?>" /></form>
  </div>
 </body>
</html>