<!-- HTML Code -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
    	<!-- load header from header.html -->
    	<?php require(dirname(__FILE__).'/res/html/header.html'); ?>
		<title>Stundenplan</title>
	</head>
	<body class="metro">
		<!-- load navbar from navbar.php -->
		<?php require(dirname(__FILE__).'/navbar.php'); ?>
        <div style="margin-top: 45px;">
            <h1><?=$lang['labels']['l.timetable']; ?></h1><br/>  
            <?//=$stundenplan->Load(); ?>
            <br/>
            <div>
                <form action="./registration.php" style="display: inline;">
                    <input type="submit" value="|Sofort loslegen!|">
                </form>
                <form action="./login.php" style="display: inline;">
    	           <input type="submit" value="|Zum Login!|">
                </form>
            </div>
        </div>
  </body>
</html>