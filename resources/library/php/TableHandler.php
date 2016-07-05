<?php
	use Utilities\Dir;
	use Utilities\UUID;
	use Utilities\Utilities;
	/**
	* TableHandler
	*/
	class TableHandler
	{
		private static $initialized = false;
		private static $tables_directory;
		private static $table_default_properties = array('tablename' => DEFAULT_TABLE_NAME, 'timestamp' => 0, 'width' => DEFAULT_TABLE_WIDTH, 'height' => DEFAULT_TABLE_HEIGHT, 'empty' => true);

		private static function initialize() {
    		if (self::$initialized) return;
    
    		Dir::include_file('Resources.Library.Php.CryptHandler');
    		Dir::include_file('Resources.Library.Php.Utilities');

    		self::$tables_directory = PROJECT_DIR.'/resources/data/'.UUID::v5(UUID, USERNAME).'/tables';
    		(!is_dir(self::$tables_directory)) ? mkdir(self::$tables_directory) : false;

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

			$filename = self::Generate_Filename($table_id);
			$properties = array('tablename' => $table_name, 'timestamp' => time(), 'width' => 5, 'height' => 8, 'empty' => true);			
			Dir::fwrite_encrypted(self::$tables_directory.'/'.$filename, array('properties' => $properties, 'table' => ''), $encryption_key);
			return Utilities::SHA1_File_Hash(self::$tables_directory.'/'.$filename);
		}

		/**
		 * Loads table depending on the given table id, checks if the sha1 values are matching and returns the decrypted data array when the table was found.
		 * If the table was not found the function returns generic properties
		 * @param string $table_id
		 * @return array
		 */
		public static function Load_Table($table_id) {
			self::initialize();

			$filename = self::Generate_Filename($table_id);
			$sha1_hash = Utilities::SHA1_File_Hash(self::$tables_directory.'/'.$filename);
			/**
			 TODO: Error page for better error visualisation 
			**/
			$key = DashboardHandler::Verify_SHA1($table_id, $sha1_hash);

			return (file_exists(self::$tables_directory.'/'.$filename)) ? CryptHandler::Decrypt($key, file_get_contents(self::$tables_directory.'/'.$filename), true) : self::$table_default_properties;
		}

		public static function Fetch_Table_Properties($table_id) {
			return self::Load_Table($table_id)['properties'];
		}

		/**
		 * Writes the given $data_array operator to file, changes the sha1 hash value and reloads the page
		 * @param string $table_id       
		 * @param array $data_array     
		 */
		public static function Save_Table($table_id, $data_array) {
			$filepath = self::$tables_directory.'/'.self::Generate_Filename($table_id);
			$key = DashboardHandler::Verify_SHA1($table_id, Utilities::SHA1_File_Hash($filepath));
			
			Dir::fwrite_encrypted($filepath, $data_array, $key);
			
			//DashboardHandler::Generate_Key($table_id, $filepath); WIP
			DashboardHandler::Set_Item_Properties($table_id, array('sha1' => Utilities::SHA1_File_Hash($filepath)));
			header('Refresh:0; url=./view_item_'.$table_id.'.html');
		}
	}
?>