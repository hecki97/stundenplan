<?php

/**
* DashboardHandler
**/
class DashboardHandler
{
  private static $initialized = false;
  private static $db_data;
  private static $data;
	private function __construct() {}

  private static function initialize() {
    if (self::$initialized) return;
    FileLoader::Load('Resources.Library.Php.LogHandler');
    FileLoader::Load('Resources.Library.Php.CryptHandler');
    FileLoader::Load('Resources.Library.Php.DatabaseHandler');
    FileLoader::Load('Resources.Library.Php.Utilities');

    $result = DatabaseHandler::MySqli_Query("SELECT uuid, encryption_key, unique_filename FROM `".DATABASE_TABLE_LOGIN."` WHERE username LIKE '".$_SESSION['username']."' LIMIT 1");
    self::$db_data = mysqli_fetch_object($result);

    $file_data = @file_get_contents(PROJECT_DIR.'/resources/data/'.self::$db_data->unique_filename);
    self::$data = (!empty(self::$db_data->unique_filename) && file_exists(PROJECT_DIR.'/resources/data/'.self::$db_data->unique_filename)) ? CryptHandler::Decrypt(self::$db_data->encryption_key, $file_data) : array();
    self::$initialized = true;
  }

  public static function Generate_List($key, $sort) {
    self::initialize();

    $table = '';
    switch ($key) {
      case 'index':
        if ($sort === SORT_ASC) {
          for ($i = 0; $i < count(self::$data); $i++) { 
            $table = self::Generate_View_Table($table, $i);
          } 
        }
        else {
          for ($i = count(self::$data) - 1; $i >= 0; $i--) { 
            $table = ($_GET['edit'] == 'true') ? self::Generate_Edit_Table($table, $i) : self::Generate_View_Table($table, $i);
          } 
        }
        break;
      default:
        self::$data = Array_Sort::Sort(self::$data, $key, $sort);
        for ($i = 0; $i < count(self::$data); $i++) { 
          $table = self::Generate_View_Table($table, $i);
        }
        break;
    }
    return $table;
  }

  private static function Generate_View_Table($table, $i) {
    $table .= "<tr><th style='width: 85px;'>".($i + 1).".</th>";
    $table .= "<th><div style='display: table-row;'><a class='button link fg-black' style='display: table-cell; float: left;'><span class='mif-star-full'></span></a><a class='button link full-size fg-black' href='./view_".self::$data[$i]['id'].".html' style='display: table-cell; font-size: 20px; float: center; left: 25px;'>".self::$data[$i]['name']."</a><p style='display: table-cell; float: right; width: 50px;'><i>".((self::$data[$i]['empty']) ? '(Empty)' : '')."</i></p></div></th>";
    $table .= "<th style='text-align: center; width: 125px;'><i>(".date('d/m/y', self::$data[$i]['timestamp']).")</i></th>";
    $table .= "<th style='text-align: right; width: 125px;'><a class='button' href='./edit_".self::$data[$i]['id'].".html'><span class='mif-pencil'></span></a><a class='button' href='./remove_from_list.php?id=".self::$data[$i]['id']."'><span class='mif-bin'></span></a></th></tr>";
    
    return $table;
  }

  //Test

  private static function Generate_Edit_Table($table, $i) {
    $table .= "<tr><th style='width: 85px;'>".($i + 1).".</th>";
    $table .= "<th><div style='display: inline;'><a class='button' style='display: inline; float: left;'><span class='mif-star-full'></span></a><a class='button' style='display: inline; float: left;'><span class='mif-arrow-up'></span></a><a class='button' style='display: inline; float: left;'><span class='mif-arrow-down'></span></a></div><a class='button link full-size fg-black' href='./view_".self::$data[$i]['id'].".html' style='display: inline; font-size: 20px; float: center; left: 25px; top: 10px;'>".self::$data[$i]['name']."</a><p style='display: inline; float: right; width: 50px;'><i>".((self::$data[$i]['empty']) ? '(Empty)' : '')."</i></p></div></th>";
    $table .= "<th style='text-align: center; width: 125px;'><i>(".date('d/m/y', self::$data[$i]['timestamp']).")</i></th>";
    $table .= "<th style='text-align: right; width: 125px;'><a class='button' href='./edit_".self::$data[$i]['id'].".html'><span class='mif-pencil'></span></a><a class='button' href='./remove_from_list.php?id=".self::$data[$i]['id']."'><span class='mif-bin'></span></a></th></tr>";
    
    return $table;
  }

  //Test

  public static function Remove_List() {
    self::initialize();

    if (!empty(self::$db_data->unique_filename) && file_exists(PROJECT_DIR.'/resources/data/'.self::$db_data->unique_filename))
      unlink(PROJECT_DIR.'/resources/data/'.self::$db_data->unique_filename);

    header('Refresh:0; url=./dashboard.html');
  }

  public static function Remove_Item_from_List($id) {
    self::initialize();

    for ($i = 0; $i < count(self::$data); $i++) { 
      if (self::$data[$i]['id'] == $id) {
        unset(self::$data[$i]);
        $new_array = array_values(self::$data);
      }
    }

    self::Save_List($new_array);
  }

  public static function Save_Tablename($tablename) {
    self::initialize();

    if (!empty(self::$db_data->unique_filename) && file_exists(PROJECT_DIR.'/resources/data/'.self::$db_data->unique_filename))
      unlink(PROJECT_DIR.'/resources/data/'.self::$db_data->unique_filename);

    /*
    $array = array();
    $array['name'] = strip_tags($tablename, '<b></b><i></i><u></u>');
    $array['id'] = uniqid();
    $array['timestamp'] = time();
    $array['width'] = 5;
    $array['height'] = 8;
    $array['empty'] = true;
    */

    $array = array('name' => strip_tags($tablename, '<b></b><i></i><u></u>'), 'id' => uniqid(), 'timestamp' => time(), 'width' => 5, 'height' => 8, 'empty' => true);
      
    $new_array[0] = $array;
    for ($i = 0; $i < count(self::$data); $i++)
      $new_array[$i+1] = self::$data[$i];    

    self::Save_List($new_array);
  }

  private static function Save_List($data) {
    // self::initialize();

    /*
    if (!empty(self::$db_data->unique_filename) && file_exists(PROJECT_DIR.'/resources/data/'.self::$db_data->unique_filename))
      unlink(PROJECT_DIR.'/resources/data/'.self::$db_data->unique_filename);
    */

    //var_dump(preg_replace(array('/\<([0-9a-zA-Z])\>(.*)\<\/([0-9a-zA-Z])>/'), '$1', $tablename));

    /*
    $array = array();
    $array['name'] = strip_tags($tablename, '<b></b><i></i><u></u>');
    $array['id'] = uniqid();
    $array['timestamp'] = time();
    $array['width'] = 5;
    $array['height'] = 8;
    $array['empty'] = true;
      
    $new_array[0] = $array;
    for ($i = 0; $i < count(self::$data); $i++)
      $new_array[$i+1] = self::$data[$i];
    */

    $key = bin2hex(openssl_random_pseudo_bytes(32));
    $unique_filename = uniqid();
    DatabaseHandler::MySqli_Query("UPDATE ".DATABASE_TABLE_LOGIN." SET `unique_filename`='".$unique_filename."' WHERE username LIKE '".$_SESSION['username']."'");
    DatabaseHandler::MySqli_Query("UPDATE ".DATABASE_TABLE_LOGIN." SET `encryption_key`='".$key."' WHERE username LIKE '".$_SESSION['username']."'");
    
    $encrypted_data = CryptHandler::Encrypt($key, $data);
    $fp = fopen(PROJECT_DIR.'/resources/data/'.$unique_filename, 'w');
    fwrite($fp, $encrypted_data);
    fclose($fp);
    LogHandler::Log('New table created', 'INFO', false);
    header('Refresh:0; url=./dashboard.html');
  }
}
?>