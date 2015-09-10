<!-- PHP Code -->
<?php
	session_start();

	$file = json_decode(file_get_contents('./test.json'), true);
	for ($i = 0; $i < count($file); $i++) { 
    	if ($file[$i][1] == $_GET['id']) break;
 	}

 	/*
 	for ($y = 0; $y < 8; $y++) { 
 		$table_body = '<tr>';
 		for ($x = 0; $x < 6; $x++) { 
 			$table_body .= '<th></th>';
 		}
 	}
 	*/
?>
<!-- HTML Code -->
<!DOCTYPE html>
<html>
	<head>
		<!-- load header from header.html -->
    	<?php require(dirname(__FILE__).'/header.html'); ?>
		<title><?=$file[$i][0]; ?></title>
	</head>
	<body>
		<!-- load navbar from navbar.php -->
		<?php require(dirname(__FILE__).'/navbar.php'); ?>

		<div class="page-content">
			<div class="page-header"><?=$file[$i][0]; ?></div>
			<div class="page-content-box page-box-shadow" style="overflow: auto; margin: 50px 125px 0px 125px; width: 75%;">
				<table class="table bordered striped" align="center" style="background-color: #ffffff; color: #000;">
					<thead>
						<tr>
							<th>/</th>
							<th>Montag</th>
							<th>Dienstag</th>
							<th>Mittwoch</th>
							<th>Donnerstag</th>
							<th>Freitag</th>
						<tr>
					</thead>
					<tbody>
						<tr>
							<th>1.</th>
							<th>-</th>
							<th>-</th>
							<th>-</th>
							<th>-</th>
							<th>-</th>
						</tr>
						<tr>
							<th>2.</th>
							<th>-</th>
							<th>-</th>
							<th>-</th>
							<th>-</th>
							<th>-</th>
						</tr>
						<tr>
							<th>3.</th>
							<th>-</th>
							<th>-</th>
							<th>-</th>
							<th>-</th>
							<th>-</th>
						</tr>
						<tr>
							<th>4.</th>
							<th>-</th>
							<th>-</th>
							<th>-</th>
							<th>-</th>
							<th>-</th>
						</tr>
						<tr>
							<th>5.</th>
							<th>-</th>
							<th>-</th>
							<th>-</th>
							<th>-</th>
							<th>-</th>
						</tr>
						<tr>
							<th>6.</th>
							<th>-</th>
							<th>-</th>
							<th>-</th>
							<th>-</th>
							<th>-</th>
						</tr>
						<tr>
							<th>7.</th>
							<th>-</th>
							<th>-</th>
							<th>-</th>
							<th>-</th>
							<th>-</th>
						</tr>
						<tr>
							<th>8.</th>
							<th>-</th>
							<th>-</th>
							<th>-</th>
							<th>-</th>
							<th>-</th>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</body>
</html>