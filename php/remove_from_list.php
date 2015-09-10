<?php
	$file = json_decode(file_get_contents('../test.json'), true);
	for ($i = 0; $i < count($file); $i++) { 
    	if ($file[$i][1] == $_GET['id']) {
        unset($file[$i]);
        $file = array_values($file);
      }
  }
  $fp = fopen('../test.json', 'w+');
  fwrite($fp, json_encode($file, JSON_FORCE_OBJECT));
  fclose($fp);
  header('Refresh:0; url=./../overview.php');
?>