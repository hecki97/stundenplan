<?php
/**
* DashboardHandler
**/
class DashboardHandler
{
  private static $initialized = false;
  private static $decrypted_data;
  private static $data_dir_path;

  private static function initialize() {
    if (self::$initialized) return;
    
    FileLoader::Load('Resources.Library.Php.LogHandler');
    FileLoader::Load('Resources.Library.Php.CryptHandler');
    FileLoader::Load('Resources.Library.Php.DatabaseHandler');
    FileLoader::Load('Resources.Library.Php.Utilities');

    $result = DatabaseHandler::MySqli_Query("SELECT uuid, encryption_key FROM `".DATABASE_TABLE_LOGIN."` WHERE username LIKE '".USERNAME."' LIMIT 1");
    $db_data = mysqli_fetch_object($result);

    self::$data_dir_path = PROJECT_DIR.'/resources/data/'.UUID::v5($db_data->uuid, USERNAME);
    (!is_dir(self::$data_dir_path)) ? mkdir(self::$data_dir_path) : false;

    self::$decrypted_data = (file_exists(self::$data_dir_path.'/data')) ? CryptHandler::Decrypt($db_data->encryption_key, @file_get_contents(self::$data_dir_path.'/data')) : array();

    self::$initialized = true;
  }  

  /**
   * Returns the dashboard table data array
   * @return array
   */
  public static function Get_Dashboard_Data() {
    self::initialize();

    return self::$decrypted_data;
  }

  /**
   * Adds a new table on top of the list and saves the list.
   * @param string $tablename
   */
  public static function Add_Item($table_name) {
    self::initialize();
          
    $table_id = uniqid();
    $encryption_key = bin2hex(openssl_random_pseudo_bytes(32));
    TableHandler::Create_Table($table_id, $encryption_key, strip_tags($table_name, '<b></b><i></i><u></u>'));
    $new_list[0] = array('id' => $table_id, 'key' => $encryption_key, 'favorite' => 'false', 'sha1' => TableHandler::Get_Sha1_File_Hash($table_id));
    for ($i = 0; $i < count(self::$decrypted_data); $i++)
      $new_list[$i+1] = self::$decrypted_data[$i];    

    self::Save_List($new_list);
  }

  /**
   * Removes an item from the list when it matches with the given $table_id 
   * @param string $table_id
   */
  public static function Remove_Item($table_id) {
    self::initialize();

    for ($i = 0; $i < count(self::$decrypted_data); $i++) { 
      if (self::$decrypted_data[$i]['id'] == $table_id) {
        unset(self::$decrypted_data[$i]);
        $new_list = array_values(self::$decrypted_data);
      }
    }
    self::Save_List($new_list);
  }

  /**
   * Clears the entire list and removes all files from the system
   */
  public static function Clear_List() {
    self::initialize();

    FileLoader::deleteDir(self::$data_dir_path);

    header('Refresh:0; url=./dashboard.html');
  }

  /**
   * Returns specific properties from a specific table item   
   * @param string $item_id
   * @param array $properties
   * @return array
   */
  public static function Get_Item_Properties($item_id, $properties) {
    self::initialize();

    $index = Array_Class::Get_Array_Index($item_id, self::$decrypted_data);
    $array = array();
    foreach ($properties as $property) {
      if (array_key_exists($property, self::$decrypted_data[$index])) {
        $array[$property] = self::$decrypted_data[$index][$property];
      }
    }
    return $array;
  }

  /**
   * Manipulates specific properties in a specific table item  
   * @param string $item_id
   * @param array $new_properties
   */
  public static function Set_Item_Properties($item_id, $new_properties) {
    self::initialize();

    $index = Array_Class::Get_Array_Index($item_id, self::$decrypted_data);
    $new_list = self::$decrypted_data;
    $new_properties_keys = array_keys($new_properties);
    foreach ($new_properties_keys as $new_property_key) {
      if (array_key_exists($new_property_key, self::$decrypted_data[$index]))
        $new_list[$index][$new_property_key] = $new_properties[$new_property_key];
    }
    self::Save_List($new_list);
  }

  /**
   * Writes the given array to file and encrypts the file.
   * @param array $data_arraydata_array
   */
  private static function Save_List($data_array) {
    $key = bin2hex(openssl_random_pseudo_bytes(32));
    DatabaseHandler::MySqli_Query("UPDATE ".DATABASE_TABLE_LOGIN." SET `encryption_key`='".$key."' WHERE username LIKE '".USERNAME."'");
    $encrypted_data = CryptHandler::Encrypt($key, $data_array);
    
    // Only for testing!
    $fp = fopen(self::$data_dir_path.'/data_output', 'w');
    fwrite($fp, print_r($data_array, true));
    fclose($fp);
    //
    
    $fp = fopen(self::$data_dir_path.'/data', 'w');
    fwrite($fp, $encrypted_data);
    fclose($fp);

    LogHandler::Log('New table created', 'INFO', false);
    header('Refresh:0; url=./dashboard.html');
  }
}
?>