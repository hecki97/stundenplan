<!-- HTML Code
<!DOCTYPE html>
<html>
  <head></head> -->
  <!--<body> -->
    <script type="text/javascript">
      function UserIsLoggedIn() {
        var listElements = document.getElementById('navbarElements').children;
        document.getElementById('navbarIndexButton').innerHTML = listElements[0].innerHTML;
        document.getElementById('navbarUserButton').innerHTML = listElements[1].innerHTML;
      }

      function Logout() {
        $.ajax({
          url: './logout.php',
          success: function() {
            window.location.href = "./index.html";
          }
        });
      }
    </script>
    <div class="app-bar darcula" id="navbar-style">
      <ul class="app-bar-menu">
        <li id="navbarIndexButton"><a href="./index.html"><span class="mif-home"></span> <?=_('button-navbar-index'); ?><sup>-dev</sup></a></li>
        <span class="app-bar-divider"></span>
        <li><a href="#" onclick="window.location.reload();"><span class="mif-loop2"></span> Reload Page</a></li>
        <span class="app-bar-divider"></span>
      </ul>
      <ul class="app-bar-menu place-right">
        <span class="app-bar-divider"></span>
        <li id="navbarUserButton"><a href="./login.html"><span class="mif-enter"></span> <?=_('button-navbar-login'); ?></a></li>
        <span class="app-bar-divider"></span>
        <li><a href="https://github.com/hecki97/stundenplan/tree/develop"><span class="mif-info"></span> v1.2-dev</a></li>
        <span class="app-bar-divider"></span>
        <li><a href="./about.html" class="fg-white"><span class="mif-cogs"></span> <?=_('button-navbar-about'); ?></a></li>
      </ul>
    </div>
    <ul id="navbarElements" style="display: none;">
      <li><a href="./dashboard-js.html"><span class="mif-home"></span> <?=_('button-navbar-dashboard'); ?><sup>-dev</sup></a></li>
      <li><a href="#" class="dropdown-toggle"><span class="mif-user"></span> <?=@$_SESSION["username"]; ?></a>
        <ul class="d-menu" data-role="dropdown">
          <li><a href="./settings.html"><span class="mif-cog"></span> <?=_('button-navbar-settings'); ?></a></li>
          <li class="divider"></li>
          <li><a href="#" onclick="Logout();"><span class="mif-exit"></span> <?=_('button-navbar-logout'); ?></a></li>
        </ul>
      </li>
    </ul>
    <?php if (DEV_MODE) { ?><script>$.Notify({type: 'warning', caption: 'Warning!', content: 'Development Build', keepOpen: true, icon: "<span class='mif-warning'></span>"});</script><?php } ?>
    <?php if (DEBUG_MODE) { ?><script>$.Notify({type: 'warning', caption: 'Warning!', content: 'Debug-Mode Activated', keepOpen: true, icon: "<span class='mif-warning'></span>"});</script><?php } ?>
    <?php if (isset($_SESSION['username'])) { ?><script type="text/javascript">UserIsLoggedIn();</script><?php } ?>
  <!--
  </body>
</html>
-->