<?php
	switch (date("N"))
	{
		case '1':
			$tag = "Montag";
			$index = 0;
			break;
			
		case '2':
			$tag = "Dienstag";
			$index = 1;
			break;

		case '3':
			$tag = "Mittwoch";
			$index = 2;
			break;

		case '4':
			$tag = "Donnerstag";
			$index = 3;
			break;

		case '5':
			$tag = "Freitag";
			$index = 4;
			break;

		case '6':
			$tag = "Samstag";
			$index = 0;
			break;

		case '7':
			$tag = "Sonntag";
			$index = 0;
			break;

		default:
			$tag = "???";
			break;
		}
?>