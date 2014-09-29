<?php
	$host = $_SERVER['SERVER_NAME'];
	include(dirname(__FILE__)."/../../../res/php/_checkDataBase.php");
	include(dirname(__FILE__)."/../../../res/php/_loadLangFiles.php");
	include(dirname(__FILE__)."/../../../res/php/_getVersionScript.php");
	include(dirname(__FILE__)."/../../../res/php/_buttonScript.php");

	//Zum Plan
	Button("register", "stundenplan/mobile/register.php");

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
	        header("Location: http://$host/stundenplan/mobile/index.php");
	      } 
	      else 
	      { 
	        ?><script type="text/javascript">alert("<?php echo $string['global']['javascript.alert.login.failed']; ?>");</script><?php
	      }
	    }
	    else
	    {
	      ?><script type="text/javascript">alert("<?php echo $string['global']['javascript.alert.felder']; ?>");</script><?php
	    }
	}
?>