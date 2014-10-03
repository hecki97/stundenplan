<?php
	include(dirname(__FILE__)."/_loadLangFiles.php");
	
	//Erstelle ein Array mit allen Wochentagen von Mo-Fr
	$wochentagArray = array("/", $string['stundenplan']['montag'], $string['stundenplan']['dienstag'], $string['stundenplan']['mittwoch'], $string['stundenplan']['donnerstag'], $string['stundenplan']['freitag']);

	function loadEditableStundenplan($wArray)
	{
		$arArray = json_decode(file_get_contents(dirname(__FILE__)."/../data/".$_SESSION['username'].".data"), true);

		$stunde = 1;
		$zeile  = "<table align='center' border='1'>";
        $zeile .= "<tr>";
        for ($i = 0; $i <= 5; $i++)
	    {
	        $zeile .= "<td>".$wArray[$i]."</td>";
	    }
	    $zeile .= "</tr>";
        for($j = 0; $j < 40; $j++)
        {
           	$zeile .= "<tr>";
           	$zeile .= "<td>".$stunde.":</td>";
           	for ($k = 0; $k < 5; $k++)
           	{ 
                $text = $arArray[$j];
                $zeile .= "<td><input type='text' size='30' maxlength='30' name='".$j."' value='".$text."'></td>";
                if ($k < 4)
                    $j++;
            }
            $zeile .= "</tr>";
            $stunde++;
       	}
       	$zeile .= "</table>";
       	return $zeile;
	}

	function loadStundenplan($wArray)
	{
		$arArray = json_decode(file_get_contents(dirname(__FILE__)."/../data/".$_SESSION['username'].".data"), true);

		$stunde = 1;
		$zeile  = "<table align='center' border='1'>";
        $zeile .= "<tr>";
        for ($i = 0; $i <= 5; $i++)
	    {
	        $zeile .= "<td>".$wArray[$i]."</td>";
	    }
	    $zeile .= "</tr>";
        for($j = 0; $j < 40; $j++)
        {
            $zeile .= "<tr>";
            $zeile .= "<td>".$stunde.":</td>";
            for ($k = 0; $k < 5; $k++)
            { 
                if (empty($arArray[$j]))
            		$arArray[$j] = "/";

                $zeile .= "<td width='250px' height='25px'>".$arArray[$j]."</td>";
                if ($k < 4)
            	    $j++;
            }
            $zeile .= "</tr>";
            $stunde++;
        }
       	$zeile .= "</table>";
       	return $zeile;
	}
?>