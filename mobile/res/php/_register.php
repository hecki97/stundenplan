<?php
	include(dirname(__FILE__)."/../../../res/php/_checkDataBase.php");
	include(dirname(__FILE__)."/../../../res/php/_loadLangFiles.php");
	include(dirname(__FILE__)."/../../../res/php/_getVersionScript.php");

	if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $username = $_POST["username"];
        $passwort = $_POST["passwort"];
        $passwort2 = $_POST["passwort2"];

        if($passwort != $passwort2 || $username == "" || $passwort == "")
        {
        	?><script type='text/javascript'>alert("<?=$string['register']['javascript.alert.felder']; ?>");</script><?php
        }
        else
       	{
       		$passwort = md5($passwort);
	        $result = mysql_query("SELECT id FROM login WHERE username LIKE '$username'");
	        $menge = mysql_num_rows($result);

	        if($menge == 0) 
	        {
	          $eintrag = "INSERT INTO login (username, password) VALUES ('$username', '$passwort')";
	          $eintragen = mysql_query($eintrag);
	          if(@$eintragen == true)
	          {
	            $return = $string['register']['alert.succes']."<b>".$username."</b>".$string['register']['alert.succes.2']."<a href='./login.php'>".$string['global']['menu.login']."</a>"; 
	          }
	          else 
	          {
	          	?><script type='text/javascript'>alert("<?=$string['register']['javascript.alert.speicherfehler']; ?>");</script><?php
	          }
	        }
	        else 
	        { 
	        	?><script type='text/javascript'>alert("<?=$string['register']['javascript.alert.bereits.vorhanden']; ?>");</script><?php
	        }
       	}
    }
?>