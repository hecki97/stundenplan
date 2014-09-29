<?php
	include(dirname(__FILE__)."/_auth.php");
	include(dirname(__FILE__)."/_loadLangFiles.php");
	include(dirname(__FILE__)."/_getVersionScript.php");
	include(dirname(__FILE__)."/_buttonScript.php");

	//Zum Plan
	Button("fback", "stundenplan/plan.php");

	//Hole Daten aus "$_SESSION['username'].data" und wandle in ein Array um
	$arArray = json_decode(file_get_contents(dirname(__FILE__)."/../data/".$_SESSION['username'].".data"), true);
	loadStundenplan($arArray);

	function loadStundenplan($array)
	{
		$stunde = 1;
		$zeile  = "<table align='center' border='1'>";
        $zeile .= "<tr>";
        $zeile .= "<td>/</td>";
        for ($i = 1; $i <= 5; $i++)
        {
        	$zeile .= "<td>".date("D", $i)."</td>";
        }
        $zeile  .= "</tr>";
        for($j = 0; $j < 40; $j++){
           	$zeile .= "<tr>";
           	$zeile .= "<td>".$stunde.":</td>";
           	for ($k = 0; $k < 5; $k++) { 
                $text = str_replace('/', '', $array[$j]);
                $zeile .= "<td><input type='text' size='30' maxlength='30' name='".$j."' value='".$text."'></td>";
                if ($k < 4)
                    $j++;
            }
            $zeile .= "</tr>";
            $stunde++;
            echo $zeile;
       	}
	}
?>