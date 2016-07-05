<?php
	use Utilities\Utilities;
	use Utilities\Dir;
	/**
	* CacheHandler
	*/
	class CacheHandler
	{	
		private static $initialized = false;
		
		private static function initialize() {
			if (self::$initialized) return;
			Dir::include_file('Resources.Library.Php.Utilities');
			self::$initialized = true;
		}

		public static function CacheData($data) {
			self::initialize();

			$session_key = uniqid();
			if (self::CheckIfDataIsCached($session_key)) return;
			$_SESSION['Cache_'.$session_key] = $data;
			
			return $session_key;
		}

		/*
		public static function ReturnCachedData($session_key) {
			if (!self::CheckIfDataIsCached($session_key)) die ('Cached data could not be returned!');
			return $_SESSION['Cache_'.$session_key];
		}
		*/

		public static function CheckIfDataIsCached($session_key) {
			self::CheckCacheTimeout($session_key);
			return isset($_SESSION['Cache_'.$session_key]);
		}

		public static function CheckCacheTimeout($session_key) {
			if (!isset($_SESSION['Cache_Created_'.$session_key])) {
				$_SESSION['Cache_Created_'.$session_key] = time();
			}
			else if (time() - $_SESSION['Cache_Created_'.$session_key] > 300) {
				session_regenerate_id(true);
				$session_keys = array_keys($_SESSION);
				for ($i = 0; $i < count($session_keys); $i++) { 
					if (preg_match('/Cache_(.*)/', $session_keys[$i])) unset($_SESSION[$session_keys[$i]]);
				}
				var_dump('Cache timed out');
				$_SESSION['Cache_Created_'.$session_key] = time();
			}
		}
	}

?>