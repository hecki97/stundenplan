<?php
	$configHandler = new ConfigHandler();

	/**
	* ConfigHandler
	**/
	class ConfigHandler
	{
		private $file_path;

		function __construct()
		{
			$this->file_path = dirname(__FILE__).'/../../config/config.ini';

			if (!file_exists($this->file_path)) die($this->file_path.' does not exist');
			$ini_array = parse_ini_file($this->file_path);

			reset($ini_array);
			while (list($key, $value) = each($ini_array)) {
    			$key = preg_replace("/([a-z])([A-Z])/", "$1_$2", $key);
    			define(strtoupper($key), $value);
			}
		}
	}
?>