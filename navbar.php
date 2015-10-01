<?php
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
        <li style="<?=$logged_out_style; ?>"><a href="./index.php"><span class="mif-home"></span> <?=NAV_BUTTON_INDEX; ?><sup><?=LANG; ?></sup></a></li>
        <li style="<?=$logged_in_style; ?>"><form action="./resources/php/logout.php"><button class="button link fg-white" type="submit"><span class="mif-switch"></span> <?=NAV_BUTTON_LOGOUT; ?></button></form></li>
        <span class="app-bar-divider"></span>
        <li><a onclick="window.location.reload();"><span class="mif-loop2"></span> <?=NAV_BUTTON_RELOAD; ?></a></li>
        <span class="app-bar-divider"></span>
      </ul>
      <ul class="app-bar-menu place-right">
        <span class="app-bar-divider"></span>
        <li style="<?=$logged_out_style; ?>"><a href="./login.php"><span class="mif-enter"></span> <?=NAV_BUTTON_LOGIN; ?></a></li>
        <li style="<?=$logged_in_style; ?>"><a href="overview.php"><span class="mif-user"></span> <?=@$_SESSION["username"]; ?></a></li>
        <span class="app-bar-divider"></span>
        <li><a href="https://github.com/hecki97/stundenplan/tree/development"><span class="mif-info"></span><?=file_get_contents('./resources/version.txt'); ?></a></li>
        <span class="app-bar-divider"></span>
        <li><a href="./about.php" class="fg-white"><span class="mif-cogs"></span> <?=NAV_BUTTON_ABOUT; ?></a></li>
      </ul>
    </div>
    <br/>
  <!--
  </body>
</html>
-->