<!-- PHP Code -->
<?php
  //include(dirname(__FILE__)."/lib/php/GithubConnectionHandler.php");
  //$githubConnectionHandler = new GithubConnectionHandler();

  require(dirname(__FILE__).'/lib/php/LanguageHandler.php');
  $languageHandler = new LanguageHandler();
  $lang = $languageHandler->array;

  $is_logged_in = false;
  $b_main_menu = $is_logged_in ? '<form action="./res/php/_logout.php" method="post"><button onclick="return show_confirm_logout();" class="element"><span class="icon-switch"></span> '.$lang['links']['a.timetable'].'-online<sup>'.$languageHandler->lang.'</sup></button></form>' : ' <a href="./index.php" class="element"><span class="icon-home"></span> '.$lang["links"]["a.timetable"].'-online<sup>'.$languageHandler->lang.'</sup></a>';
  $b_sign_in = $is_logged_in ? '<a class="element place-right no-phone no-tablet"><span class="icon-unlocked"></span> '.$_SESSION['username'].'</a>' : '<a href="./login.php" class="element place-right no-phone no-tablet"><span class="icon-key"></span> '.$lang['links']['a.login'].'</a>';
?>
<!-- HTML Code -->
<html>
  <head>
    <!-- JavaScript Code -->
    <script type="text/javascript">
      function show_confirm_logout()
      {
        return confirm("<?=$lang['javascript.alerts']['j.logout']; ?>");
      }
    </script>
    <!---->
  </head>
  <body>
    <nav class="navigation-bar dark fixed-top">
      <nav class="navigation-bar-content">
        <!--<form action="./res/php/_logout.php" method="post"><button onclick="return show_confirm_logout();" class="element"><span class="icon-switch"></span> <?//=$lang['links']['a.timetable']; ?>-online<sup><?=$languageHandler->lang; ?></sup></button></form>-->
        <?=$b_main_menu; ?>
        <span class="element-divider"></span>
        <button class="element brand no-phone no-tablet" onclick="window.location.reload();"><span class="icon-spin"></span></button>
        <span class="element-divider"></span>

        <a href="./about.php" class="element brand place-right no-phone no-tablet"><span class="icon-cog"></span></a>
        <span class="element-divider place-right"></span>
        <a class="element place-right no-phone no-tablet"> <?//=$githubConnectionHandler->github_json['repo']; ?> alpha dev<!--<?=$version; ?>--></a>
        <span class="element-divider place-right"></span>
        <!--<a class="element place-right no-phone no-tablet"><span class="icon-unlocked"></span> <?//=$_SESSION['username']; ?></a>-->
        <?=$b_sign_in; ?>
        <span class="element-divider place-right"></span>
      </nav>
    </nav>
    <br/>
  </body>
</html>