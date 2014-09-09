<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php $root = realpath($_SERVER["DOCUMENT_ROOT"]); ?>
<?php include("$root/stundenplan/res/html/htmlHead.html"); ?>
<?php include("$root/stundenplan/res/php/_registration.php"); ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="de" lang="de">
<head>
    <title>Registrierung</title>
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
          <a href="./login.php" class="element place-right no-phone no-tablet">
            <span class="icon-key"></span> <?=$string['global']['menu.login']; ?>
          </a>
          <span class="element-divider place-right"></span>
      </nav>
    </nav>
  </header>

<div class="container" style="text-align: center;">
  <h1><?=$string['register']['registrierung']; ?></h1>
    <form action="registration.php" method="post">
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

        <?php $result = mysql_query("SELECT id FROM login WHERE username LIKE '$username'"); ?>
        <?php $menge = mysql_num_rows($result); ?>

        <?php if($menge == 0) : ?> 
        <ul>
          <?php $eintrag = "INSERT INTO login (username, password) VALUES ('$username', '$passwort')"; ?>
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