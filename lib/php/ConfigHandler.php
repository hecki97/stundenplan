<?php

	/**
	* ConfigHandler
	*/
	class ConfigHandler
	{
		// 
		define('LOAD_CONFIG_FROM_FILE', false);
		define('CONFIG_FILE_PATH', '')

		//
		define('USE_DATABASE_FOR_LOGIN', false);

		define('USE_MULTILANG', true);
		define('ALLOWED_LANGUAGES', 'en, de, la');
		define('DEFAULT_LANGUAGE_PATH', '');


		function __construct(argument)
		{
			if (USE_DATABASE_FOR_LOGIN) require(dirname(__FILE__).'/lib/php/DatabaseHandler.php');

			if (USE_MULTILANG) require(dirname(__FILE__).'/lib/php/LanguageHandler.php');
		}
	}

?>