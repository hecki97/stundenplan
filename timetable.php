<!-- PHP Code -->
<?php
	session_start();

	$file = json_decode(file_get_contents('resources/data/'.$_SESSION["username"].'.json'), true);
  	for ($key = 0; $key < count($file); $key++) { 
      $id = $file[$key]['id'];
      if ($id == $_GET['id']) break;
  	}

  	$table  = '<table class="table bordered striped" align="center" style="background-color: #ffffff; color: #000;">';
  	$table .= '<thead><tr><th>/</th><th>Montag</th><th>Dienstag</th><th>Mittwoch</th><th>Donnerstag</th><th>Freitag</th><tr></thead>';
  	$table .= '<tbody>';
  	for ($y = 1; $y <= $file[$key]['height']; $y++) { 
    	$table .= '<tr><th>'.$y.'</th>';
    	for ($x = 1; $x <= $file[$key]['width']; $x++) {
      		$placeholder = (empty($file[$key]['savedata']['x'.$x.'y'.$y])) ? '-' : $file[$key]['savedata']['x'.$x.'y'.$y];
      		$value = (empty($file[$key]['savedata']['x'.$x.'y'.$y])) ? '' : $file[$key]['savedata']['x'.$x.'y'.$y];
      		$table .= '<th>'.$placeholder.'</th>';
    	}
    	$table .= '</tr>';
  	}
  	$table .= '</tbody></table>';
?>
<!-- HTML Code -->
<!DOCTYPE html>
<html>
	<head>
		<!-- load header from header.php -->
    	<?php require(dirname(__FILE__).'/header.php'); ?>
		<title><?=$file[$key]['name']; ?></title>
	</head>
	<body>
		<!-- load navbar from navbar.php -->
		<?php require(dirname(__FILE__).'/navbar.php'); ?>

		<div class="page-content">
			<div class="page-header"><?=$file[$key]['name']; ?></div>
			<div class="table-container content-box-shadow" style="width: 90%; margin-bottom: 50px;">
        		<?=$table; ?>
      		</div>
		</div>
	</body>
</html>