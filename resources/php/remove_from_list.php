<?php
  session_start();
	$file = json_decode(file_get_contents('../data/'.$_SESSION['username'].'.json'), true);
	for ($i = 0; $i < count($file); $i++) { 
    	if ($file[$i]['id'] == $_GET['id']) {
        unset($file[$i]);
        $file = array_values($file);
      }
  }
  $fp = fopen('../data/'.$_SESSION["username"].'.json', 'w');
  fwrite($fp, json_encode($file, JSON_FORCE_OBJECT));
  fclose($fp);
  header('Refresh:0; url=./../../overview.php');
?>