<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php $host = $_SERVER['SERVER_NAME']; ?>
<?php include(dirname(__FILE__)."/res/php/_index.php"); ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="de" lang="de">
 <head>
    <?php include(dirname(__FILE__)."/res/html/mobileHtmlHead.html"); ?>
    <title>Index</title>
    <style type="text/css">

        .style_li {
            text-align: center;
        }

        body {
            position: absolute;
            top: 0; bottom: 0; left: 0; right: 0;
            height: 100%;

            margin-left: auto;
            margin-right: auto;
        }
        body:before {
            content: "";
            position: absolute;
            background: url(./res/gif/6.gif);
            background-size: 100%;
            z-index: -1; /* Keep the background behind the content */
            height: 100%; width: 100%; /* Using Glen Maddern's trick /via @mente */

            /* don't forget to use the prefixes you need */
            transform: scale(5);
            transform-origin: top left;
            -webkit-filter: blur(2px);
            -moz-filter: blur(2px);
            -o-filter: blur(2px);
            -ms-filter: blur(2px);
            filter: blur(2px);
        }

        li
        {
            display:table-cell;
            vertical-align: middle;

            text-align: left;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
     <script>
        function show_confirm_logout()
        {
            return confirm("<?=$string['plan']['javascript.confirm.logout']; ?>");
        }
    </script>
 </head>
  <body class="metro">
  <header>
    <nav class="navigation-bar dark fixed-top">
      <nav class="navigation-bar-content" style="text-align: center;">
        <button class="element" onclick="window.location.reload();"><span class="icon-home"></span> Stundenplan<sup>online</sup></button>
      </nav>
    </nav>
  </header>
    <nav class="vertical-menu" style="text-align: center;">
        <ul>
            <a href="./today.php">
                <br/><li class="title style_li " style="font-size: 65px;"><?=date("d.m.y"); ?></li>
                <li class="style_li" style="top: 5px;"><h1 style="font-size: 25px;"><?=$tag ?></h1></li>
            </a><br/>
            <li><a href="./today.php"><h1 style="font-size: 20px;">► <?=$string['mobile']['index']['a.heute']; ?></h1></a></li>
            <li><a href="./plan.php"><h1 style="font-size: 20px;">► <?=$string['mobile']['index']['a.stundenplan']; ?></h1></a></li>
            <br/>
            <li><a href="./create.php"><h1 style="font-size: 20px;">► <?=$string['mobile']['index']['a.erstellen']; ?></h1></a></li>
            <li><a href="./edit.php"><h1 style="font-size: 20px;">► <?=$string['mobile']['index']['a.bearbeiten']; ?></h1></a></li>
            <li><a href="./info.php"><h1 style="font-size: 20px;">► <?=$string['mobile']['index']['a.info']; ?></h1></a></li>
            <br/>
            <li><a href='./res/php/_logout.php' onclick="return show_confirm_logout();"><h1 style="font-size: 20px;">► <?=$string['mobile']['index']['a.logout']; ?></h1></a></li>
            <br/>
            <li class="style_li">Version: <?=$version ?></li>
        </ul>
        </nav>
 </body>
</html>