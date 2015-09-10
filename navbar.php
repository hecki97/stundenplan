<!-- PHP Code -->
<?php
  require(dirname(__FILE__).'/lib/php/BingImageHandler.php');
  $bingImageHandler = new BingImageHandler();

  require_once(dirname(__FILE__).'/lib/php/LanguageHandler.php');
  $languageHandler = new LanguageHandler();
  $lang = $languageHandler->array;

  switch (isset($_SESSION["username"])) {
    case true:
      $logged_in_style = 'display: block;';
      $logged_out_style = 'display: none;';
      break;
    
    default:
      $logged_in_style = 'display: none;';
      $logged_out_style = 'display: block;';
      break;
  }
?>
<!-- HTML Code
<!DOCTYPE html>
<html>
  <head>
  -->
    <!-- JavaScript Code
    <script type="text/javascript">
      function show_confirm_logout()
      {
        return confirm("<?//=$lang['javascript.alerts']['j.logout']; ?>");
      }
    </script>
    -->
  <!--
  </head>
  <body>
  -->
    <div class="app-bar darcula">
      <ul class="app-bar-menu">
        <li style="<?=$logged_out_style; ?>"><a href="./index.php"><span class="mif-menu"></span> Stundenplan<sup>de</sup></a></li>
        <li style="<?=$logged_in_style; ?>"><form action="./php/logout.php"><button class="button link fg-white" type="submit"><span class="mif-switch"></span> Logout</button></form></li>
        <span class="app-bar-divider"></span>
        <li><a onclick="window.location.reload();"><span class="mif-loop2"></span> Reload</a></li>
        <span class="app-bar-divider"></span>
      </ul>
      <ul class="app-bar-menu place-right">
        <span class="app-bar-divider"></span>
        <li style="<?=$logged_out_style; ?>"><a href="./login.php"><span class="mif-enter"></span> Login</a></li>
        <li style="<?=$logged_in_style; ?>"><a href="overview.php"><span class="mif-user"></span> <?=@$_SESSION["username"]; ?></a></li>
        <span class="app-bar-divider"></span>
        <li><a><span class="mif-info"></span> v0.1 dev</a></li>
        <span class="app-bar-divider"></span>
        <li><a href="./about.php" class="fg-white"><span class="mif-cogs"></span> About</a></li>
      </ul>
    </div>
    <br/>
  <!--
  </body>
</html>
-->