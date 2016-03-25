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

	// Redirect to .html instead of .php
	$redirect_url = preg_replace('/\.php/', '.html', $_SERVER['REQUEST_URI']);
	if ($_SERVER['REQUEST_URI'] !== $redirect_url) header('Refresh:0; url='.$redirect_url);

	FileLoader::Load('Resources.Library.Php.BingImageHandler');
  	//FileLoader::Load('Resources.Library.Php.LanguageHandler');
  	FileLoader::Load('Resources.Library.Php.DatabaseHandler');

  	if (function_exists('gettext'))
	{
		$language = 'en_US';
		putenv('LANG='.$language);
		setlocale(LC_ALL, $language);

		bindtextdomain($language, PROJECT_DIR.'/resources/locale');
		bind_textdomain_codeset($language, 'UTF-8');
		textdomain($language);
	}

  	if (isset($_SESSION['username'])) {
  		define('USERNAME', $_SESSION['username']);
		$result = DatabaseHandler::MySqli_Query("SELECT uuid FROM `".DATABASE_TABLE_LOGIN."` WHERE username LIKE '".USERNAME."' LIMIT 1");
    	$db_data = mysqli_fetch_object($result);
    	define('UUID', $db_data->uuid);
  	}

	//Debug Mode Show all errors
	if (DEBUG_MODE) {
		ini_set('display_errors', 1);
  		error_reporting(E_ALL | E_STRICT);
	}
	else
		ini_set('display_errors', 0);

	if (BING_BACKGROUND_IMAGE_ENABLED) BingImageHandler::Get_Image_from_Bing();
?>