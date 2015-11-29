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
			if (isset($_SESSION['username'])) {
				$result = DatabaseHandler::Mysqli_Query("SELECT uuid FROM `login` WHERE username LIKE '".$_SESSION['username']."' LIMIT 1");
				self::$user_uuid = mysqli_fetch_object($result);
			}
			self::$path = PROJECT_DIR.'/logs/general/'.date('Y').'/'.date('F');
			self::$user_path = PROJECT_DIR.'/logs/user/'.date('Y').'/'.date('F').'/'.date('d-m-Y');
			self::Create_folder_if_not_exists(self::$path);
			self::Create_folder_if_not_exists(self::$user_path);

			self::$initialized = true;
		}

		private static function Create_folder_if_not_exists($path) {
			$array = explode('/', $path);
			$filepath = '';
			
			for ($i = 0; $i < count($array); $i++) {
				$filepath = $filepath.$array[$i].'/';
				
				if (!file_exists($filepath))
					mkdir($filepath);
			}
		}
		
		public static function Log_Error($message, $general = true)
		{
			self::Log($message, 'ERROR', $general);
		}

		public static function Log($message, $type = 'INFO', $general = true) {
			self::initialize();
			
			$fp = $general ? fopen(self::$path.'/'.date('d-m-Y').'.log', 'a') : fopen(self::$user_path.'/'.self::$user_uuid->uuid, 'a');
			//hackish solution but it works (more or less)
			fwrite($fp, "[".date('Y-d-m')."]"."[".date('H:i:s')."] - ".basename(debug_backtrace()[0]['file'])." - ".$type." - ".$message."\r\n");
			fclose($fp);
		}
	}
?>