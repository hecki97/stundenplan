<?php
    $bg_type = 'bg2';
    $main_dir = './img/website';
    $dir_bgs = $main_dir.'/backgrounds';
    $background_images = Array();
    if (is_dir($dir_bgs)) {
        $array = array_diff(scandir($dir_bgs, 1), array('..', '.'));
        foreach ($array as $file) {
            if (explode('_', $file)[0] === $bg_type) array_push($background_images, $dir_bgs.'/'.$file);
        }
    }
    else
    {
        $filepath = $main_dir.$bg_type.'_bw.jpg';
        if (file_exists($file)) array_push($background_images, $filepath);
    }
?>
<!-- HTML Code -->
<!DOCTYPE html>
<html>
	<head>
		<title>My first Website</title>
        <script type="text/javascript">
            var totdDiv, tips, backgroundImages = <?=json_encode($background_images); ?>;

            window.onload = function() {
                tips = document.getElementById('tips').children;
                
                if (backgroundImages.length > 0) document.body.style.backgroundImage = 'url(' + backgroundImages[getRandomInt(0, backgroundImages.length - 1)] + ')';
                if (tips.length > 0) document.getElementById('tipoftheday').innerHTML = tips[getRandomInt(0, tips.length - 1)].innerHTML;
            }

            function getRandomInt(min, max) {
                return Math.floor(Math.random() * (max - min + 1)) + min;
            }
        </script>
        <style type="text/css">
            body {
                background-color: #000;
                text-align: center;
            }
            footer {
                color: #fff;
                margin-top: 1rem;
            }
            .box {
                width: 800px;
                margin: 2rem auto 0 auto;
                padding-top: 1rem;
                background-color: #f1f1f1;
            }
            #tipoftheday {
                padding-bottom: 1rem;
            }
            #tips {
                display: none;
            }
        </style>
	</head>
	<body>
		<div class="box">
            <h1>Welcome Interweb Novice!</h1>
            <h2>Thanks for visting my Site!</h2>
            <h3>List of my current Projects:</h3>
            <ul>
                <li>Timetable (HTML/JS/CSS/PHP Project)</li>
                <li>Several projects written in pascal (PASCAL Project)</li>
                <li>Custom installer written in batch (BATCH Project)</li>
            </ul>
            -----
            <br/>
            <h3>Tip of the day:</h3>
            <div id="tipoftheday">
                <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.</p>
                <img src="img/website/loading.gif" width="65%">
            </div>
        </div>
        <form method="post" action="index.php" style="margin-top: 1rem;">
            <button type="submit">Go to my site!</button>
        </form>
        <footer>
            Recommend Browsers: Internet Explorer 4.0, Netscape Navigator 4.0, Netscape Communicator 4.0, Opera 3.0<br/>
            Last updated 09/18/99 - by heckinator2000
        </footer>
        <div id="tips">
            <div>
                <p>There's this cool new search engine called "Google!", be sure to check it out! <a href="http://www.google.com">http://google.stanford.edu</a></p>
                <img src="img/website/super-cool-new-search-engine.gif" width="65%">
            </div>
            <div>
                <p>There's this cool new instant messenger called "ICQ", be sure to check it out! <a href="http://www.icq.com">http://www.icq.com</a></p>
                <img src="img/website/super-cool-new-instant-messenger.gif" width="65%">
            </div>
            <div>
                <p>There's this cool site where you can sell unwanted stuff, be sure to check it out! <a href="http://www.ebay.com">http://pages.ebay.com</a></p>
                <img src="img/website/super-cool-site-for-selling-unwanted-stuff.gif" width="65%">
            </div>
            <div>
                <p>There's this cool site where you can create your own website, be sure to check it out! <a href="http://www.geocities.com">http://www.geocities.com</a></p>
                <img src="img/website/super-cool-site-for-making-your-own-website.gif" width="65%">
            </div>
        </div>
    </body>
</html>