<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php $host = $_SERVER['SERVER_NAME']; ?>
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
        <button class="element" onclick="window.location.reload();"><span class="icon-home"></span> Stundenplan<sup>online</sup></button>
      </nav>
    </nav>
  </header>

<div class="container" style="text-align: center;">
  <h1><?=$string['register']['registrierung']; ?></h1>
    <form action="register.php" method="post">
      <h3><?=$string['register']['daten']; ?></h3>
      
      <table cellpadding="2" align="center">
        <tr>
          <th>
            <span style ='font-size:15px'><?=$string['register']['username']; ?></span>
          </th>
          <th>
            <span style ='font-size:15px'><input type="text" name="username" /></span>
          </th>
        </tr>
        <tr>
          <th>
            <span style ='font-size:15px'><?=$string['register']['password']; ?></span>
          </th>
          <th>
            <span style ='font-size:15px'><input type="password" name="passwort" /></span>
          </th>
        </tr>
        <tr>
          <th>
            <span style ='font-size:15px'><?=$string['register']['password.wdh']; ?></span>
          </th>
          <th>
            <span style ='font-size:15px'><input type="password" name="passwort2" /></span>
          </th>
        </tr>
      </table>
      <br><input type="submit" name="uregister" value="<?=$string['global']['button.submit.register']; ?>">
      <br><br><input type="submit" name="plan" value="<?=$string['global']['button.submit.plan']; ?>">
             
      <?php if ($_SERVER['REQUEST_METHOD'] == 'POST') : ?>
      <ul>
        <?php $username = $_POST["username"]; ?>
        <?php $passwort = $_POST["passwort"]; ?>
        <?php $passwort2 = $_POST["passwort2"]; ?>

        <?php if($passwort != $passwort2 || $username == "" || $passwort == "") : ?>
        <ul>
          <script type="text/javascript">alert("<?=$string['register']['javascript.alert.felder']; ?>");</script> 
          <?php exit; ?>
        </ul>
        <?php endif; ?> 
        <?php $passwort = md5($passwort); ?>

        <?php $result = mysql_query("SELECT id FROM stundenplan_login WHERE username LIKE '$username'"); ?>
        <?php $menge = mysql_num_rows($result); ?>

        <?php if($menge == 0) : ?> 
        <ul>
          <?php $eintrag = "INSERT INTO stundenplan_login (username, password) VALUES ('$username', '$passwort')"; ?>
          <?php $eintragen = mysql_query($eintrag); ?>
          <?php if(@$eintragen == true) : ?>
          <ul>
            <?=$string['register']['alert.succes']; ?><b><?=$username; ?></b><?=$string['register']['alert.succes.2']; ?> <a href="./login.php"><?=$string['global']['menu.login']; ?></a> 
          </ul>
          <?php else : ?> 
          <ul>
            <script type="text/javascript">alert("<?=$string['register']['javascript.alert.speicherfehler']; ?>");</script>
          </ul>
          <?php endif; ?>
        </ul>
        <?php else : ?> 
        <ul> 
          <script type="text/javascript">alert("<?=$string['register']['javascript.alert.bereits.vorhanden']; ?>");</script>
        </ul>
        <?php endif; ?>
      </ul>
      <?php endif; ?>
    </form>
  </div>
</body>
</html>