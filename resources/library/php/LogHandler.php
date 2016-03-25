<?php
	/**
	* LogHandler
	*/
	class LogHandler
	{
		private function __construct() {}
		private static $initialized = false;

		private static $path;
		private static $user_path;
		private static $file;
		private static $user_uuid;

		public static function initialize() {
			if (self::$initialized) return;
			FileLoader::Load('Resources.Library.Php.DatabaseHandler');
			FileLoader::Load('Resources.Library.Php.Utilities');

			if (isset($_SESSION['username'])) {
				$result = DatabaseHandler::Mysqli_Query("SELECT uuid FROM `login` WHERE username LIKE '".$_SESSION['username']."' LIMIT 1");
				self::$user_uuid = mysqli_fetch_object($result);
			}
			self::$path = PROJECT_DIR.'/logs/general/'.date(LOG_HANDLER_DATE_YEAR).'/'.date(LOG_HANDLER_DATE_MONTH);
			self::$user_path = PROJECT_DIR.'/logs/user/'.date(LOG_HANDLER_DATE_YEAR).'/'.date(LOG_HANDLER_DATE_MONTH).'/'.date(LOG_HANDLER_DATE_DAY);
			FileLoader::Create_new_folder(self::$path);
			FileLoader::Create_new_folder(self::$user_path);

			self::$initialized = true;
		}
		
		public static function Log_Error($message, $general = true)
		{
			self::Log($message, 'ERROR', $general);
		}

		public static function Log($message, $type = 'INFO', $general = true) {
			self::initialize();
			
			$fp = $general ? fopen(self::$path.'/'.date(LOG_HANDLER_DATE_DAY).'.log', 'a') : fopen(self::$user_path.'/'.self::$user_uuid->uuid, 'a');
			//hackish solution but it works (more or less)
			fwrite($fp, "[".date(LOG_HANDLER_DATE_DAY)."]"."[".date(LOG_HANDLER_DATE_TIME)."] - ".basename(debug_backtrace()[0]['file'])." - ".$type." - ".$message."\r\n");
			fclose($fp);
		}
	}
?>