<?php
	$host = $_SERVER['SERVER_NAME'];
	include(dirname(__FILE__)."/_checkDataBase.php");
	include(dirname(__FILE__)."/_loadLangFiles.php");
	include(dirname(__FILE__)."/_getVersionScript.php");

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	    if (!empty($_POST["username"]) && !empty($_POST["password"]))
	    {
	      session_start();

	      $username = $_POST["username"]; 
	      $passwort = md5($_POST["password"]); 

	      $abfrage = "SELECT username, password FROM login WHERE username LIKE '$username' LIMIT 1"; 
	      $ergebnis = mysql_query($abfrage); 
	      $row = mysql_fetch_object($ergebnis); 

	      if($row->password == $passwort) 
	      { 
	        $_SESSION["username"] = $username; 
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