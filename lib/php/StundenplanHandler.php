<?php
	include(dirname(__FILE__)."/_loadLangFiles.php");
	//Erstelle ein Array mit allen Wochentagen von Mo-Fr
	$wArray = array("/", $string['weekdays']['w.monday'], $string['weekdays']['w.tuesday'], $string['weekdays']['w.wednesday'], $string['weekdays']['w.thursday'], $string['weekdays']['w.friday']);

	class StundenplanHandler
	{
		public function Create()
		{
			$array = array();
		    for ($i = 0; $i < 40; $i++)
		        array_push($array, "");

		    file_put_contents(dirname(__FILE__)."/../data/".$_SESSION['username'].".data", json_encode($array));
		}

		public function Save_to_File()
		{
			$array = array();
	    	for ($i = 0; $i < 40; $i++)
	            array_push($array, $_POST[$i]);
	    	
	    	file_put_contents(dirname(__FILE__)."/../data/".$_SESSION['username'].".data", json_encode($array));	
		}

		public function Edit()
		{
			global $wArray;
			$arArray = json_decode(file_get_contents(dirname(__FILE__)."/../data/".$_SESSION['username'].".data"), true);

			$stunde = 1;
			$zeile  = "<table align='center' border='1'>";
	        $zeile .= "<tr>";
	        for ($i = 0; $i <= 5; $i++)
		        $zeile .= "<td>".$wArray[$i]."</td>";

		    $zeile .= "</tr>";
	        for($j = 0; $j < 40; $j++)
	        {
	           	$zeile .= "<tr>";
	           	$zeile .= "<td>".$stunde.":</td>";
	           	for ($k = 0; $k < 5; $k++)
	           	{ 
	                $text = $arArray[$j];
	                $zeile .= "<td><input type='text' size='30' maxlength='30' name='".$j."' value='".trim($text, "/")."'></td>";
	                if ($k < 4)
	                    $j++;
	            }
	            $zeile .= "</tr>";
	            $stunde++;
	       	}
	       	$zeile .= "</table>";
	       	return $zeile;
		}

		public function Load_from_File()
		{
			global $wArray;
			$arArray = json_decode(file_get_contents(dirname(__FILE__)."/../data/".$_SESSION['username'].".data"), true);

			$stunde = 1;
			$zeile  = "<table align='center' border='1'>";
	        $zeile .= "<tr>";
	        for ($i = 0; $i <= 5; $i++)
		        $zeile .= "<td>".$wArray[$i]."</td>";

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
	}
?>