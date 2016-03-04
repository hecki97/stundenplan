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
        <li style="<?=$logged_out_style; ?>"><a href="./index.html"><span class="mif-home"></span> <?=_('button-navbar-index'); ?><sup><?//=LANG; ?>-dev</sup></a></li>
        <li style="<?=$logged_in_style; ?>"><a href="./dashboard.html"><span class="mif-home"></span> <?=_('button-navbar-dashboard'); ?><sup><?//=LANG; ?>-dev</sup></a></li>
        <span class="app-bar-divider"></span>
        <li><a onclick="window.location.reload();"><span class="mif-loop2"></span> <?//=NAV_BUTTON_RELOAD; ?></a></li>
        <span class="app-bar-divider"></span>
      </ul>
      <ul class="app-bar-menu place-right">
        <span class="app-bar-divider"></span>
        <li style="<?=$logged_out_style; ?>"><a href="./login.html"><span class="mif-enter"></span> <?=_('button-navbar-login'); ?></a></li>
        <li style="<?=$logged_in_style; ?>"><a href="dashboard.html" class="dropdown-toggle"><span class="mif-user"></span> <?=@$_SESSION["username"]; ?></a>
          <ul class="d-menu" data-role="dropdown">
            <li><a href="./settings.html"><span class="mif-cog"></span> <?=_('button-navbar-settings'); ?></a></li>
            <li class="divider"></li>
            <li><a href="./logout.html"><span class="mif-exit"></span> <?=_('button-navbar-logout'); ?></a></li>
          </ul>
        </li>
        <span class="app-bar-divider"></span>
        <li><a href="https://github.com/hecki97/stundenplan/tree/develop"><span class="mif-info"></span> v1.2-dev<?//=Git::GetGitCommitHash(1, 2); ?></a></li>
        <span class="app-bar-divider"></span>
        <li><a href="./about.html" class="fg-white"><span class="mif-cogs"></span> <?=_('button-navbar-about'); ?></a></li>
      </ul>
    </div>
    <br/>
  <!--
  </body>
</html>
-->