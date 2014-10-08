<?php
	include(dirname(__FILE__)."/_checkDataBase.php");
	include(dirname(__FILE__)."/_loadLangFiles.php");
	include(dirname(__FILE__)."/_getVersionScript.php");

	if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $username = $_POST["username"];
        $passwort = $_POST["passwort"];
        $passwort2 = $_POST["passwort2"];

        if($passwort != $passwort2 || $username == "" || $passwort == "")
        {
        	?><script type='text/javascript'>alert("<?=$string['javascript.alerts']['j.fields']; ?>");</script><?php
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
	            $return = $string['labels']['l.registration.succes']."<b>".$username."</b>".$string['labels']['l.registration.succes.2']."<a href='./login.php'>".$string['global']['menu.login']."</a>"; 
	          }
	          else 
	          {
	          	?><script type='text/javascript'>alert("<?=$string['javascript.alerts']['j.error']; ?>");</script><?php
	          }
	        }
	        else 
	        { 
	        	?><script type='text/javascript'>alert("<?=$string['javascript.alerts']['j.already.exists']; ?>");</script><?php
	        }
       	}
    }
?>