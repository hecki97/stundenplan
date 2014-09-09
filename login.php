<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php $root = realpath($_SERVER["DOCUMENT_ROOT"]); ?>
<?php $host = $_SERVER['SERVER_NAME']; ?>
<?php include("$root/stundenplan/res/html/htmlHead.html"); ?>
<?php include("$root/stundenplan/res/php/_login.php"); ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="de" lang="de">
 <head>
    <title>Login</title>
 </head>
  <body class="metro">
  <header>
    <nav class="navigation-bar dark fixed-top">
      <nav class="navigation-bar-content">
          <a href="http://<?=$host; ?>/stundenplan/index.php" class="element"><span class="icon-arrow-left-5"></span> Stundenplan-online<sup><?=$lang; ?></sup></a>
   
          <span class="element-divider"></span>
          <button class="element brand no-phone no-tablet" onclick="window.location.reload();"><span class="icon-spin"></span></button>
          <span class="element-divider"></span>

          <a href="./info.php" class="element brand place-right no-phone no-tablet"><span class="icon-cog"></span></a>
          <span class="element-divider place-right"></span>
          <a class="element place-right no-phone no-tablet">
            <?=$version; ?>
          </a>
          <span class="element-divider place-right"></span>
          <a href="#" class="element place-right no-phone no-tablet">
            <span class="icon-key"></span> <?=$string['global']['menu.login']; ?>
          </a>
          <span class="element-divider place-right"></span>
      </nav>
    </nav>
  </header>

  <div class="container" style="text-align: center;">
    <h1><?=$string['login']['ueberschrift']; ?></h1>
    <form action="login.php" method="post">
      <table cellpadding="2" align="center">
        <tr>
          <th>
            <span style ='font-size:15px'><?=$string['login']['username']; ?></span>
          </th>
          <th>
            <span style ='font-size:15px'><input type="text" name="username" /></span>
          </th>
        </tr>
        <tr>
          <th>
            <span style ='font-size:15px'><?=$string['login']['password']; ?></span>
          </th>
          <th>
            <span style ='font-size:15px'><input type="password" name="password" /></span>
          </th>
        </tr>
      </table>
      <br/><input type="submit" value="<?=$string['login']['button.submit.anmelden']; ?>" />
      <br/><input type="submit" name="register" value="<?=$string['login']['button.submit.registrieren']; ?>" />
      <br/><br/><br/><input type="submit" name="fback" value="<?=$string['global']['button.submit.plan']; ?>" />
    </form>
  </div>

 </body>
</html>