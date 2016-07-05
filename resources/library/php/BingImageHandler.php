<?php
	use Utilities\Dir;
	use Utilities\NetworkUtilities;
	/**
	* BingImageHandler
	**/
	class BingImageHandler
	{
		private static $file_full_path;
		private static $dir_path;

		private static $initialized = false;

		private static function initialize()
		{
			if (self::$initialized) return;
			Dir::include_file('Resources.Library.Php.LogHandler');
			Dir::include_file('Resources.Library.Php.Utilities');

			self::$dir_path = PROJECT_DIR.'/'.BING_BG_IMG_FILE_PATH;
			self::$file_full_path = self::$dir_path.'/'.BING_BG_IMG_FILE_NAME;
			self::$initialized = true;
		}

		public static function Get_Image_from_Bing()
		{
			self::initialize();
			if (!BING_BG_IMG_ENABLED) return;
			if (!is_dir(self::$dir_path) && !file_exists(self::$dir_path)) {
				mkdir(self::$dir_path) or LogHandler::Log('Failed to create dir "'.self::$dir_path.'"', 'ERROR');
				LogHandler::Log('Created dir "'.self::$dir_path.'"');
			}

			if (!NetworkUtilities::Is_connected()) return;

			if (!file_exists(self::$file_full_path) || (strtotime(date('d-m-Y')) > strtotime(date('d-m-Y', filemtime(self::$file_full_path))))) {
				if (copy('https://www.bing.com/ImageResolution.aspx?w=1920&h=1080', self::$file_full_path))
					LogHandler::Log('Updated Bing background image');
				else
					LogHandler::Log_Error('Failed to update Bing Background Image');
			}
		}
	}
?>