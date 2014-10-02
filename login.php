<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php include(dirname(__FILE__)."/res/html/htmlHead.html"); ?>
<?php include(dirname(__FILE__)."/res/php/_login.php"); ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="de" lang="de">
 <head>
    <title>Login</title>
 </head>
  <body class="metro">
  <header>
    <nav class="navigation-bar dark fixed-top">
      <nav class="navigation-bar-content">
          <a href="./index.php" class="element"><span class="icon-arrow-left-5"></span> Stundenplan-online<sup><?=$lang; ?></sup></a>
   
          <span class="element-divider"></span>
          <button class="element brand no-phone no-tablet" onclick="window.location.reload();"><span class="icon-spin"></span></button>
          <span class="element-divider"></span>

          <a class="element brand place-right no-phone no-tablet"><span class="icon-cog"></span></a>
          <span class="element-divider place-right"></span>
          <a class="element place-right no-phone no-tablet"><?=$version; ?></a>
          <span class="element-divider place-right"></span>
          <a class="element place-right no-phone no-tablet"><span class="icon-key"></span> <?=$string['global']['menu.login']; ?></a>
          <span class="element-divider place-right"></span>
      </nav>
    </nav>
  </header>

  <div class="container">
    <h1><?=$string['login']['ueberschrift']; ?></h1>
    <form action="login.php" method="post" style="display: inline;">
      <table cellpadding="2" align="center">
        <tr>
          <th><?=$string['login']['username']; ?></th>
          <th><input type="text" name="username" /></th>
        </tr>
        <tr>
          <th><?=$string['login']['password']; ?></th>
          <th><input type="password" name="password" /></th>
        </tr>
      </table>
      <br/><input type="submit" value="<?=$string['login']['button.submit.anmelden']; ?>" />
    </form>
    <form action="./registration.php" style="display: inline;"><input type="submit" name="register" value="<?=$string['login']['button.submit.registrieren']; ?>" /></form>
  </div>
 </body>
</html>