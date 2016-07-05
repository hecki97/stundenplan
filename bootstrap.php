<?php
	session_start();
	define('PROJECT_DIR', dirname(__FILE__));
	define('HTTP_HOST', $_SERVER['HTTP_HOST']);

	use Utilities\Dir;
	use Utilities\IniParser;

	require_once(PROJECT_DIR.'/resources/library/php/Utilities.php');

	//Register
	Dir::rgdir('Resources.Config', PROJECT_DIR.'/resources/config');
	Dir::rgdir('Resources.Data', PROJECT_DIR.'/resources/data');
	Dir::rgdir('Resources.Lang', PROJECT_DIR.'/resources/lang');
	Dir::rgdir('Resources.Library', PROJECT_DIR.'/resources/library');
	Dir::rgdir('Resources.Library.Php', PROJECT_DIR.'/resources/library/php');
	Dir::rgdir('Resources.Php', PROJECT_DIR.'/resources/php');

	// Parse .ini Files
	if (!file_exists(PROJECT_DIR.'/resources/config/'.HTTP_HOST.'.config.ini'))
		Dir::mkfile(PROJECT_DIR.'/resources/config/'.HTTP_HOST.'.config.ini', file_get_contents(PROJECT_DIR.'/resources/config/default.config.ini'));
	IniParser::Parse(PROJECT_DIR.'/resources/config/'.HTTP_HOST.'.config.ini', false);

	// Redirect to .html instead of .php
	$redirect_url = preg_replace('/\.php/', '.html', $_SERVER['REQUEST_URI']);
	if ($_SERVER['REQUEST_URI'] !== $redirect_url) header('Refresh:0; url='.$redirect_url);

	Dir::include_file('Resources.Library.Php.BingImageHandler');
  	Dir::include_file('Resources.Library.Php.DatabaseHandler');

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
		$result = DatabaseHandler::MySqli_Query("SELECT uuid FROM `".DATABASE_TABLE_NAME."` WHERE username LIKE '".USERNAME."' LIMIT 1");
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

	BingImageHandler::Get_Image_from_Bing();

	//if (!isset($_SESSION['IE-Troll']) && !(isset($_SERVER['HTTP_USER_AGENT']) && (strpos($_SERVER['HTTP_USER_AGENT'], 'Trident') !== false || strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false))) { header('Refresh:0; url=./website.html'); $_SESSION['IE-Troll'] = true;} 
?>