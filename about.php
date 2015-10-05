<?php session_start(); ?>
<!-- HTML Code -->
<!DOCTYPE html>
<html>
	<head>
		<!-- load header from header.php -->
    	<?php require(dirname(__FILE__)."/header.php"); ?>
		<title><?=ABOUT_TITLE; ?></title>
	</head>
	<body>
		<!-- load navbar from navbar.php -->
		<?php require(dirname(__FILE__)."/navbar.php"); ?>
		<div class="page-content">
			<div class="page-header"><?=ABOUT_PAGE_HEADER; ?></div>
			<div class="page-content-box content-box-shadow">
				<dl>
					<dt><h2><?=ABOUT_PAGE_CONTENT_BOX_SOURCECODE; ?></h2></dt>
					<dd><h3><a href="https://github.com/hecki97/stundenplan">github.com</h3></a></dd>
					<br/>
					<dt><h2><?=ABOUT_PAGE_CONTENT_BOX_BACKGROUND_IMAGE_BY; ?></h2></dt>
					<dd><h3><a href="http://www.bing.com">bing.com</a></h3></dd>
					<br/>
					<dt><h2><?=ABOUT_PAGE_CONTENT_BOX_POWERED_BY; ?> </h2></dt>
					<dd><h3><a href="http://metroui.org.ua">Metro UI CSS 3.0</a></h3></dd>
					<br/>
					<dt><h2><a href="./mobile/index.php"><?//=$lang['labels']['l.mobile']; ?></a></h2></dt>
					<br/>
					<dt><h4><?=ABOUT_PAGE_CONTENT_BOX_COPYRIGHT; ?></h4></dt>
					<dt><h4><?=ABOUT_PAGE_CONTENT_BOX_VERSION; ?> 0.1 dev <?//=$version; ?></h4></dt>
				</dl>
			</div>
		</div>
	</body>
</html>