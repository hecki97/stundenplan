<?php
	include_once(dirname(__FILE__)."/_checkBrowserLang.php");

	$allowed_langs = array ('de', 'en', 'la');
	$lang = lang_getFromBrowser ($allowed_langs, 'de', null, false);

	if ($lang == 'de')
		$string = json_decode(file_get_contents(dirname(__FILE__)."/../lang/de_DE.lang"), true);
	else if ($lang == 'en')
		$string = json_decode(file_get_contents(dirname(__FILE__)."/../lang/en_US.lang"), true);
	else
		$string = json_decode(file_get_contents(dirname(__FILE__)."/../lang/la_LA.lang"), true);
?>