<?php
	/**
	* TableHandler
	*/
	class TableHandler
	{
		private static $initialized = false;
		private static $tables_dir_path;
		private static $fallback_properties = array('tablename' => 'Tablename', 'timestamp' => 0, 'width' => 0, 'height' => 0, 'empty' => true);

		private static function initialize() {
    		if (self::$initialized) return;
    
    		FileLoader::Load('Resources.Library.Php.CryptHandler');
    		FileLoader::Load('Resources.Library.Php.Utilities');

    		self::$tables_dir_path = PROJECT_DIR.'/resources/data/'.UUID::v5(UUID, USERNAME).'/tables';
    		(!is_dir(self::$tables_dir_path)) ? mkdir(self::$tables_dir_path) : false;

    		self::$initialized = true;
  		}

  		/**
  		 * Generates the filename depending on the given $table_id
  		 * @param string $table_id
  		 */
		private static function Generate_Filename($table_id) {
			return '0x'.hash('crc32', $table_id).hash('crc32b', $table_id);
		}

		/**
		 * Creates a new table and writes the table to file
		 * @param string $table_id       
		 * @param string $encryption_key 
		 * @param string $table_name     
		 */
		public static function Create_Table($table_id, $encryption_key, $table_name) {
			self::initialize();

			$properties = array('tablename' => $table_name, 'timestamp' => time(), 'width' => 5, 'height' => 8, 'empty' => true);			
			FileLoader::file_write_encrypted(self::$tables_dir_path.'/'.self::Generate_Filename($table_id), array('properties' => $properties, 'table' => ''), $encryption_key);
		}

		/**
		 * Loads table depending on the given table id, checks if the sha1 values are matching and returns the decrypted data array when the table was found.
		 * If the table was not found the function returns generic properties
		 * @param string $table_id
		 * @return array
		 */
		public static function Load_Table($table_id) {
			self::initialize();

			$table_filename = self::Generate_Filename($table_id);

			/**
			 TODO: Error page for better error visualisation 
			**/
			if (DashboardHandler::Get_Item_Properties($table_id, array('sha1'))['sha1'] != self::Get_Sha1_File_Hash($table_id)) die('SHA1 checksum mismatch error!');

			return (file_exists(self::$tables_dir_path.'/'.$table_filename)) ? CryptHandler::Decrypt(DashboardHandler::Get_Item_Properties($table_id, array('key'))['key'], file_get_contents(self::$tables_dir_path.'/'.$table_filename), true) : self::$fallback_properties;
		}

		/**
		 * Writes the given $data_array operator to file, changes the sha1 hash value and reloads the page
		 * @param string $table_id       
		 * @param array $data_array     
		 * @param string $encryption_key 
		 */
		private static function Save_Table($table_id, $data_array, $encryption_key) {
			FileLoader::file_write_encrypted($file_path, $data_array, $encryption_key);
			
			DashboardHandler::Set_Item_Properties($table_id, array('sha1' => self::Get_Sha1_File_Hash($table_id)));
			header('Refresh:0; url=./view_item_'.$table_id.'.html');
		}

		/**
		 * Generates and returns the sha1 file hash from a table
		 * @param string $table_id
		 */
		public static function Get_Sha1_File_Hash($table_id) {
			self::initialize();

			$file_path = self::$tables_dir_path.'/'.self::Generate_Filename($table_id);

			if (!file_exists($file_path)) die('file '.self::Generate_Filename($table_id).' not found');

			return sha1_file($file_path);
		}
	}
?>