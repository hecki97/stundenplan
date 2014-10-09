<?php
	$host = $_SERVER['SERVER_NAME'];
	include(dirname(__FILE__)."/_checkDataBase.php");
	include(dirname(__FILE__)."/_loadLangFiles.php");
	include(dirname(__FILE__)."/_getVersionScript.php");

	$isMobile = (bool)preg_match('#\b(ip(hone|od)|android\b.+\bmobile|opera m(ob|in)i|windows (phone|ce)|blackberry'.
                '|s(ymbian|eries60|amsung)|p(alm|rofile/midp|laystation portable)|nokia|fennec|htc[\-_]'.
                '|up\.browser|[1-4][0-9]{2}x[1-4][0-9]{2})\b#i', $_SERVER['HTTP_USER_AGENT'] );

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	    if (!empty($_POST["username"]) && !empty($_POST["password"]))
	    {
	      session_start();

	      	$username = $_POST["username"]; 
	      	$passwort = md5($_POST["password"]); 

	    	$abfrage = "SELECT username, password FROM $table WHERE username LIKE '$username' LIMIT 1"; 
	    	$ergebnis = mysql_query($abfrage); 
	    	$row = mysql_fetch_object($ergebnis);
	      
	      	if($row->password == $passwort) 
	      	{ 
	        	$_SESSION["username"] = $username;

	        	if($isMobile)
    				header("Location: http://$host/stundenplan/mobile/index.php");
    			else
	        		header("Location: http://$host/stundenplan/index.php");
	      	} 
	      	else 
	      	{ 
	        	?><script type="text/javascript">alert("<?=$string['javascript.alerts']['j.login.failed']; ?>");</script><?php
	      	}
	    }
	    else
	    {
	      ?><script type="text/javascript">alert("<?=$string['javascript.alerts']['j.fields']; ?>");</script><?php
	    }
	}
?>