<?php
	define('PROJECT_DIR', dirname(__FILE__));

	require_once(PROJECT_DIR.'/resources/library/php/Utilities.php');
	//Register
	FileLoader::Register('Resources.Config', PROJECT_DIR.'/resources/config');
	FileLoader::Register('Resources.Data', PROJECT_DIR.'/resources/data');
	FileLoader::Register('Resources.Lang', PROJECT_DIR.'/resources/lang');
	FileLoader::Register('Resources.Library', PROJECT_DIR.'/resources/library');
	FileLoader::Register('Resources.Library.Php', PROJECT_DIR.'/resources/library/php');
	FileLoader::Register('Resources.Php', PROJECT_DIR.'/resources/php');

	// Parse .ini Files
	IniParser::Parse(PROJECT_DIR.'/resources/config/config.ini', false);

	FileLoader::Load('Resources.Library.Php.BingImageHandler');
  	FileLoader::Load('Resources.Library.Php.LanguageHandler');

  	// FileLoader::Load('Resources.Library.Php.LogHandler');
  	// LogHandler::Log(basename(__FILE__, '.php'), 'Test', 'ERROR');

  	BingImageHandler::Get_Image_from_Bing();
  	if (!defined('LANG')) LanguageHandler::ParseLangFile();

	//Debug Mode Show all errors
	if (DEBUG_MODE) {
		ini_set('display_errors', 1);
  		error_reporting(E_ALL | E_STRICT);
	}
?>