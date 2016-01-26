<?php
	session_start();
	define('PROJECT_DIR', dirname(__FILE__));
	define('HTTP_HOST', $_SERVER['HTTP_HOST']);

	require_once(PROJECT_DIR.'/resources/library/php/Utilities.php');

	//Register
	FileLoader::Register('Resources.Config', PROJECT_DIR.'/resources/config');
	FileLoader::Register('Resources.Data', PROJECT_DIR.'/resources/data');
	FileLoader::Register('Resources.Lang', PROJECT_DIR.'/resources/lang');
	FileLoader::Register('Resources.Library', PROJECT_DIR.'/resources/library');
	FileLoader::Register('Resources.Library.Php', PROJECT_DIR.'/resources/library/php');
	FileLoader::Register('Resources.Php', PROJECT_DIR.'/resources/php');

	// Parse .ini Files
	if (!file_exists(PROJECT_DIR.'/resources/config/'.HTTP_HOST.'.config.ini'))
		FileLoader::Create_new_file(PROJECT_DIR.'/resources/config/'.HTTP_HOST.'.config.ini', file_get_contents(PROJECT_DIR.'/resources/config/default.config.ini'));
	IniParser::Parse(PROJECT_DIR.'/resources/config/'.HTTP_HOST.'.config.ini', false);

	FileLoader::Load('Resources.Library.Php.BingImageHandler');
  	FileLoader::Load('Resources.Library.Php.LanguageHandler');
  	FileLoader::Load('Resources.Library.Php.DatabaseHandler');

  	if (isset($_SESSION['username'])) {
  		define('USERNAME', $_SESSION['username']);
		$result = DatabaseHandler::MySqli_Query("SELECT uuid FROM `".DATABASE_TABLE_LOGIN."` WHERE username LIKE '".USERNAME."' LIMIT 1");
    	$db_data = mysqli_fetch_object($result);
    	define('UUID', $db_data->uuid);
  	}

  	if (!defined('LANG')) LanguageHandler::ParseLangFile();

	//Debug Mode Show all errors
	if (DEBUG_MODE) {
		ini_set('display_errors', 1);
  		error_reporting(E_ALL | E_STRICT);
	}
	else
		ini_set('display_errors', 0);

	if (BING_BACKGROUND_IMAGE_ENABLED) BingImageHandler::Get_Image_from_Bing();

	//Warnings
	if (DEV_MODE) echo "<span style='color: #fed545;'>WARNING!: This is an <b>in development build</b>. Things can and will be broken. For the best experience and security you should always use a master build.</span><br/>";
	if (DEBUG_MODE) echo "<span style='color: #fed545;'>WARNING!: Debug-mode activated.</span>\n";
?>