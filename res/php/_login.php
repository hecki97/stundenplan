<?php
	$root = realpath($_SERVER["DOCUMENT_ROOT"]);
	$host = $_SERVER['SERVER_NAME'];
	include("$root/stundenplan/res/php/_checkDataBase.php");
	include("$root/stundenplan/res/php/_loadLangFiles.php");
	include("$root/stundenplan/res/php/_getVersionScript.php");
	include("$root/stundenplan/res/php/_buttonScript.php");

	//Registrieren
	Button("register", "stundenplan/registration.php");
	//Zum Plan
	Button("fback", "stundenplan/index.php");

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
	        header("Location: http://$host/stundenplan/plan.php");
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