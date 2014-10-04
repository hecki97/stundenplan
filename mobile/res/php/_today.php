<?php
	$host = $_SERVER['SERVER_NAME'];
	include(dirname(__FILE__)."/_auth.php");
	include(dirname(__FILE__)."/../../../res/php/_loadLangFiles.php");
	include(dirname(__FILE__)."/../../../res/php/_getVersionScript.php");

	if (!file_exists(dirname(__FILE__)."/../../../res/data/".$_SESSION['username'].".data"))
		header("Location: http://$host/stundenplan/mobile/create.php");

	function loadStundenplan()
	{
		include(dirname(__FILE__)."/_getWeekdays.php");

		$arArray = json_decode(file_get_contents(dirname(__FILE__)."/../../../res/data/".$_SESSION['username'].".data"), true);
        $stunde = 1;
        $zeile  = "<table align='center' border='1'>";
        $zeile .= "<tr>";
        $zeile .= "<td>/</td>";
        $zeile .= "<td><h2>".$tag."</h2></td>";
        $zeile .= "</tr>";
        
        for($i = 0; $i < 8; $i++)
        {
            $zeile .= "<tr>";
            $zeile .= "<td><h2> ".$stunde.":</h2></td>";
            for ($j = 0; $j < 1; $j++)
            { 
                    if (date("N") < 6)
                      $zeile .= "<td width='300px' height='35px'><h1>".$arArray[$index]."</h1></td>";
                    else
                      $zeile .= "<td width='300px' height='35px'><h1>/</h1></td>";
            }
            $zeile .= "</tr>";
            $stunde++;
            $index += 5;
        }
        $zeile .= "</table>";
        return $zeile;
    }
?>