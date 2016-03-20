<?php require('bootstrap.php'); ?>
<!-- HTML Code -->
<!DOCTYPE html>
<html>
	<head>
		<!-- load header from header.php -->
    	<?php require('header.php'); ?>
		<title><?=_('about-title'); ?></title>
	</head>
	<body>
		<!-- load navbar from navbar.php -->
		<?php require('navbar.php'); ?>
		<div class="page-content">
			<div class="page-header"><?=_('about-page-header'); ?></div>
			<div class="page-content-box content-box-shadow">
				<dl>
					<dt><h2><?=_('about-content-box-sourcecode'); ?></h2></dt>
					<dd><h3><a href="https://github.com/hecki97/stundenplan">github.com</a></h3></dd>
					<br/>
					<dt><h2><?=_('about-content-box-bg-image'); ?></h2></dt>
					<dd><h3><a href="http://www.bing.com">bing.com</a></h3></dd>
					<br/>
					<dt><h2><?=_('about-content-box-powered-by'); ?> </h2></dt>
					<dd><h3><a href="http://metroui.org.ua">Metro UI CSS 3.0</a></h3></dd>
					<br/>
					<dt><h2><a href="./mobile/index.php"><?//=$lang['labels']['l.mobile']; ?></a></h2></dt>
					<br/>
					<dt><h4><?=_('about-content-box-copyright'); ?></h4></dt>
					<dt><h4><?=_('about-content-box-version'); ?> 0.1 dev</h4></dt>
				</dl>
			</div>
		</div>
	</body>
</html>