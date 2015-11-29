<?php
  session_start();
  require('bootstrap.php');
  FileLoader::Load('Resources.Library.Php.CryptHandler');
  FileLoader::Load('Resources.Library.Php.DatabaseHandler');
  FileLoader::Load('Resources.Library.Php.Utilities');

  $result = DatabaseHandler::MySqli_Query("SELECT encryption_key, unique_filename FROM `".DATABASE_TABLE_LOGIN."` WHERE username LIKE '".$_SESSION['username']."' LIMIT 1");
  $db_data = mysqli_fetch_object($result);
    
  $file_data = @file_get_contents(PROJECT_DIR.'/resources/data/'.$db_data->unique_filename);
  $data = (!empty($db_data->unique_filename) && file_exists(PROJECT_DIR.'/resources/data/'.$db_data->unique_filename)) ? CryptHandler::Decrypt($db_data->encryption_key, $file_data) : exit;

  if (!empty($db_data->unique_filename) && file_exists(PROJECT_DIR.'/resources/data/'.$db_data->unique_filename))
      unlink(PROJECT_DIR.'/resources/data/'.$db_data->unique_filename);

	for ($i = 0; $i < count($data); $i++) { 
    	if ($data[$i]['id'] == $_GET['id']) {
        unset($data[$i]);
        $data = array_values($data);
      }
  }

  $key = bin2hex(openssl_random_pseudo_bytes(32));
  $unique_filename = uniqid();
  DatabaseHandler::MySqli_Query("UPDATE ".DATABASE_TABLE_LOGIN." SET `unique_filename`='".$unique_filename."' WHERE username LIKE '".$_SESSION['username']."'");
  DatabaseHandler::MySqli_Query("UPDATE ".DATABASE_TABLE_LOGIN." SET `encryption_key`='".$key."' WHERE username LIKE '".$_SESSION['username']."'");
    
  $encrypted_data = CryptHandler::Encrypt($key, $data);
  $fp = fopen(PROJECT_DIR.'/resources/data/'.$unique_filename, 'w');
  fwrite($fp, $encrypted_data);
  fclose($fp);
  LogHandler::Log('Removed Table', 'INFO', false);
  header('Refresh:0; url=./dashboard.html');
?>