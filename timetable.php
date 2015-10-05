<!-- PHP Code -->
<?php
	session_start();

  require_once(dirname(__FILE__).'/resources/library/php/StundenplanHandler.php');
  $stundenplanHandler = new StundenplanHandler($_GET['id']);
  $table = $stundenplanHandler->Load_Timetable_View();
?>
<!-- HTML Code -->
<!DOCTYPE html>
<html>
	<head>
		<!-- load header from header.php -->
    	<?php require(dirname(__FILE__).'/header.php'); ?>
		<title><?=$stundenplanHandler->decrypted_file[$stundenplanHandler->key]['name']; ?></title>
	</head>
	<body>
		<!-- load navbar from navbar.php -->
		<?php require(dirname(__FILE__).'/navbar.php'); ?>

		<div class="page-content">
			<div class="page-header"><?=$stundenplanHandler->decrypted_file[$stundenplanHandler->key]['name']; ?></div>
			<div class="table-container content-box-shadow" style="width: 90%; margin-bottom: 50px;">
        		<?=$table; ?>
      		</div>
		</div>
	</body>
</html>