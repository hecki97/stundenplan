<?php
/**
* DashboardHandler
**/
class DashboardHandler
{
  private static $initialized = false;
  private static $decrypted_data;
  private static $data_dir_path;
	private function __construct() {}

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
   * Generates the list depending on the given operators $column, $sort, $edit and returns the list.
   * @param string   $column
   * @param constant $sort
   * @param boolean  $edit
   */
  public static function Generate_List($column, $sort, $edit = false) {
    self::initialize();

    $list = '';
    switch ($column) {
      case 'index':
        if ($sort === SORT_ASC) {
          for ($i = 0; $i < count(self::$decrypted_data); $i++) { 
            $list .= self::Generate_Item($i, $edit);
          } 
        }
        else {
          for ($i = count(self::$decrypted_data) - 1; $i >= 0; $i--) { 
            $list .= self::Generate_Item($i, $edit);
          } 
        }
        break;
      default:
        self::$decrypted_data = Array_Sort::Sort(self::$decrypted_data, $column, $sort);
        for ($i = 0; $i < count(self::$decrypted_data); $i++) { 
          $list .= self::Generate_Item($i, $edit);
        }
        break;
    }
    return $list;
  }

  /**
   * Generates one item depending on the given operaters $i, $edit and then returns it.
   * @param integer $i    
   * @param boolean $edit
   */
  private static function Generate_Item($i, $edit = false) {
    $item  = "<tr><th id='dashboard-table-column-index'>".($i + 1).".</th>";
    $item .= "<th><div id='dashboard-table-column-table-name'>";
    $item .= "<a class='button link fg-black' id='fav-star'>";
    $item .= (self::$decrypted_data[$i]['favorite']) ? "<span class='mif-star-full'></span>" : "<span class='mif-star-empty'></span>";
    $item .= "</a>";
    $item .= ($edit) ? "<div><a class='button disabled' style='display: inline; float: left; top: 8.5px;'><span class='mif-arrow-up'></span></a><a class='button disabled' style='display: inline; float: left; top: 8.5px;'><span class='mif-arrow-down'></span></a></div>" : "";
    $item .= "<a class='button link full-size fg-black' id='table-name' href='./view_item_".self::$decrypted_data[$i]['id'].".html'>".self::$decrypted_data[$i]['name']."</a>";
    $item .= "<p id='is-empty'><i>".((self::$decrypted_data[$i]['empty']) ? '(Empty)' : '')."</i></p>";
    $item .= "</div></th>";
    $item .= "<th id='dashboard-table-column-date'><i>(".date('d/m/y', self::$decrypted_data[$i]['timestamp']).")</i></th>";
    $item .= "<th id='dashboard-table-column-options'>";
    $item .= "<a class='button' href='./edit_item_".self::$decrypted_data[$i]['id'].".html'><span class='mif-pencil'></span></a><a class='button' href='./remove_item_".self::$decrypted_data[$i]['id'].".html'><span class='mif-bin'></span></a></th></tr>";

    return $item;
  }

  /**
   * Removes an item from the list when it matches with the given $table_id 
   * @param string $table_id
   */
  public static function Remove_Item_from_List($table_id) {
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
   * Adds a new table on top of the list and saves the list.
   * @param string $tablename
   */
  public static function Add_Item($tablename) {
    self::initialize();
          
    $new_list[0] = array('name' => strip_tags($tablename, '<b></b><i></i><u></u>'), 'id' => uniqid('', true), 'timestamp' => time(), 'width' => 5, 'height' => 8, 'empty' => true, 'favorite' => false);
    for ($i = 0; $i < count(self::$decrypted_data); $i++)
      $new_list[$i+1] = self::$decrypted_data[$i];    

    self::Save_List($new_list);
  }

  /**
   * Writes the given operator to file and encrypts the file.
   * 
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