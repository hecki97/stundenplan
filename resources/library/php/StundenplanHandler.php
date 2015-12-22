<?php
  use \Colors\RandomColor;

	/**
	* StundenplanHandler
	**/
	class StundenplanHandler
	{
    private static $initialized = false;
    private static $db_data;
    private static $data;
    private static $id;
    private static $key;

    public static $table_name;
    public static $table_width;
    public static $table_height;
    private function __construct() {}

    private static $rand_hex_colors;

    private static function initialize() {
      if (self::$initialized) return;
      //FileLoader::Load('Resources.Library.Php.LogHandler');
      FileLoader::Load('Resources.Library.Php.CryptHandler');
      FileLoader::Load('Resources.Library.Php.DatabaseHandler');
      FileLoader::Load('Resources.Library.Php.Utilities');

      //Test
      FileLoader::Load('Resources.Library.Php.RandomColor');
      //

      $result = DatabaseHandler::MySqli_Query("SELECT encryption_key, unique_filename FROM `".DATABASE_TABLE_LOGIN."` WHERE username LIKE '".$_SESSION['username']."' LIMIT 1");
      self::$db_data = mysqli_fetch_object($result);
    
      $file_data = @file_get_contents(PROJECT_DIR.'/resources/data/'.self::$db_data->unique_filename);
      self::$data = (!empty(self::$db_data->unique_filename) && file_exists(PROJECT_DIR.'/resources/data/'.self::$db_data->unique_filename)) ? CryptHandler::Decrypt(self::$db_data->encryption_key, $file_data) : array();
      
      self::$id = $_GET['id'];
      for ($i = 0; $i < count(self::$data); $i++) { 
        if (self::$data[$i]['id'] == self::$id) self::$key = $i;
      }

      self::$table_name = self::$data[self::$key]['name'];
      self::$table_width = self::$data[self::$key]['width'];
      self::$table_height = self::$data[self::$key]['height'];

      //Test
      $max_cells = self::$data[self::$key]['width'] * self::$data[self::$key]['height'];
      self::$rand_hex_colors = RandomColor::many($max_cells, array('luminosity' => 'dark', 'hue'=>'random'));
      //

      self::$initialized = true;
    }

		public static function Load_Timetable_View() {
			self::initialize();

      $table = '';
      $count = 0;
  		for ($y = 1; $y <= self::$data[self::$key]['height']; $y++) { 
   			$table .= '<tr><th>'.$y.'</th>';
   			for ($x = 1; $x <= self::$data[self::$key]['width']; $x++) {
   		   	$placeholder = (empty(self::$data[self::$key]['savedata']['x'.$x.'y'.$y])) ? '-' : self::$data[self::$key]['savedata']['x'.$x.'y'.$y].'</span>';
          //$value = (empty(self::$data[self::$key]['savedata']['x'.$x.'y'.$y])) ? '' : self::$data[self::$key]['savedata']['x'.$x.'y'.$y];
   				$table .= '<th><span style="color: '.self::$rand_hex_colors[$count].';">'.$placeholder.'</span></th>';
          $count++;
   			}
    		$table .= '</tr>';
  		}

  		return $table;
		}

		public static function Load_Timetable_Edit() {
      self::initialize();

      $table = '';
  		for ($y = 1; $y <= self::$data[self::$key]['height']; $y++) { 
    		$table .= '<tr><th>'.$y.'</th>';
    		for ($x = 1; $x <= self::$data[self::$key]['width']; $x++) {
      		$placeholder = (empty(self::$data[self::$key]['savedata']['x'.$x.'y'.$y])) ? '-' : self::$data[self::$key]['savedata']['x'.$x.'y'.$y];
      		$value = (empty(self::$data[self::$key]['savedata']['x'.$x.'y'.$y])) ? '' : self::$data[self::$key]['savedata']['x'.$x.'y'.$y];
      		$table .= '<th><input class="timetable-th-input" name="x'.$x.'y'.$y.'" type="text" placeholder="'.$placeholder.'" value="'.$value.'" style="text-align: center;"/></th>';
    		}
    		$table .= '</tr>';
  		}

  	 return $table;
		}

		public static function Save_Timetable() {
			if (!empty(self::$db_data->unique_filename) && file_exists(PROJECT_DIR.'/resources/data/'.self::$db_data->unique_filename))
        unlink(PROJECT_DIR.'/resources/data/'.self::$db_data->unique_filename);

      self::$data[self::$key]['name'] = $_POST['tablename'];
      self::$data[self::$key]['timestamp'] = time();
      self::$data[self::$key]['width'] = $_POST['width'];
      self::$data[self::$key]['height'] = $_POST['height'];
      if (array_key_exists('savedata', self::$data[self::$key])) unset(self::$data[self::$key]['savedata']);

      $savedata_array = array();
    	for ($y = 1; $y <= self::$data[self::$key]['height'] ; $y++) { 
     		for ($x = 1; $x <= self::$data[self::$key]['width'] ; $x++) {
     			if (empty($_POST['x'.$x.'y'.$y])) continue;
         	$savedata_array['x'.$x.'y'.$y] = $_POST['x'.$x.'y'.$y];
       	}
     	}

      self::$data[self::$key]['empty'] = (empty($savedata_array)) ? true : false;
      self::$data[self::$key]['savedata'] = $savedata_array;
      
      $key = bin2hex(openssl_random_pseudo_bytes(32));
      $unique_filename = uniqid();
      DatabaseHandler::MySqli_Query("UPDATE ".DATABASE_TABLE_LOGIN." SET `unique_filename`='".$unique_filename."' WHERE username LIKE '".$_SESSION['username']."'");
      DatabaseHandler::MySqli_Query("UPDATE ".DATABASE_TABLE_LOGIN." SET `encryption_key`='".$key."' WHERE username LIKE '".$_SESSION['username']."'");
    
      $encrypted_data = CryptHandler::Encrypt($key, self::$data);
      $fp = fopen(PROJECT_DIR.'/resources/data/'.$unique_filename, 'w');
      fwrite($fp, $encrypted_data);
      fclose($fp);
      LogHandler::Log('Updated Table', 'INFO', false);
		}
	}
?>