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
  <body>
  -->
    <div class="app-bar darcula" id="navbar-style">
      <ul class="app-bar-menu">
        <li style="<?=$logged_out_style; ?>"><a href="./index.html"><span class="mif-home"></span> <?=NAV_BUTTON_INDEX; ?><sup><?=LANG; ?></sup></a></li>
        <!--<li style="<?=$logged_in_style; ?>"><form action="./resources/php/logout.php"><button class="button link fg-white" type="submit"><span class="mif-switch"></span> <?//=NAV_BUTTON_LOGOUT; ?></button></form></li>-->
        <li style="<?=$logged_in_style; ?>"><a href="./dashboard.html"><span class="mif-home"></span> <?=NAV_BUTTON_DASHBOARD; ?></a></li>
        <span class="app-bar-divider"></span>
        <!--<li><a onclick="window.location.reload();"><span class="mif-loop2"></span> <?//=NAV_BUTTON_RELOAD; ?></a></li>
        <span class="app-bar-divider"></span>-->
      </ul>
      <ul class="app-bar-menu place-right">
        <span class="app-bar-divider"></span>
        <li style="<?=$logged_out_style; ?>"><a href="./login.html"><span class="mif-enter"></span> <?=NAV_BUTTON_LOGIN; ?></a></li>
        <li style="<?=$logged_in_style; ?>"><a href="dashboard.html" class="dropdown-toggle"><span class="mif-user"></span> <?=@$_SESSION["username"]; ?></a>
          <ul class="d-menu" data-role="dropdown">
            <li><a href="./settings.html"><span class="mif-cog"></span> <?=NAV_BUTTON_SETTINGS; ?></a></li>
            <li class="divider"></li>
            <li><a href="./logout.html"><span class="mif-exit"></span> <?=NAV_BUTTON_LOGOUT; ?></a></li>
          </ul>
        </li>
        <span class="app-bar-divider"></span>
        <li><a href="https://github.com/hecki97/stundenplan/tree/development"><span class="mif-info"></span><?=file_get_contents('./resources/version.txt'); ?></a></li>
        <span class="app-bar-divider"></span>
        <li><a href="./about.html" class="fg-white"><span class="mif-cogs"></span> <?=NAV_BUTTON_ABOUT; ?></a></li>
      </ul>
    </div>
    <br/>
  <!--
  </body>
</html>
-->