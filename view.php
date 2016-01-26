<!-- PHP Code -->
<?php
  require('bootstrap.php');

  FileLoader::Load('Resources.Library.Php.TableViewController');

  $edit = (@$_GET['mode'] === 'edit') ? true : false;
  $div_content_box_display = 'display: '.($edit ? 'block' : 'none').';';
  $div_header_display = 'display: '.($edit ? 'none' : 'block').';';

  $tableView = new TableViewController($_GET['id'], $edit);

  if ($_SERVER['REQUEST_METHOD'] == 'POST' && @$_GET['mode'] == 'edit') {
    if (@$_POST['save']) {
      $tableView->Save_TableView();
    }
    header('Refresh:0; url=./view.php?id='.$_GET['id']);
  }
?>
<!-- HTML Code -->
<!DOCTYPE html>
<html>
	<head>
		<!-- load header from header.php -->
    	<?php require(dirname(__FILE__).'/header.php'); ?>
		<title><?=$tableView->table_name; ?></title>
	</head>
	<body>
		<!-- load navbar from navbar.php -->
		<?php require(dirname(__FILE__).'/navbar.php'); ?>

    <form method="post">

		<div class="page-content">
      <div class="page-header" style="<?=$div_header_display; ?>"><?=$tableView->table_name; ?></div>

      <div id="container" style="<?=$div_content_box_display; ?>">
        <div class="page-content-box content-box-shadow">
          <div class="input-control text full-size" data-role="input">
            <span class="mif-table prepend-icon"></span>
            <input type="text" placeholder="Tablename" name="tablename" value="<?=$tableView->table_name; ?>">
            <button class="button helper-button clear"><span class="mif-cross"></span></button>
          </div>
          Width: <input type="text" placeholder="Width" maxlength="2" size="7" min="0" step="1" name="width" value="<?=$tableView->table_width; ?>" />
          Height: <input type="text" placeholder="Height" maxlength="2" size="7" min="0" step="1" name="height" value="<?=$tableView->table_height; ?>" /><br/>
          <input type="submit" name="save" value="Save!" style="height: 25px; margin-top: 10px;" />
          <input type="submit" name="cancel" value="Cancel!" style="height: 25px; margin-top: 10px;" />
        </div>
      </div>

			<div class="table-container content-box-shadow" style="width: 90%; margin-bottom: 50px;">
        <?=$tableView->Generate_TableView(); ?>
      </div>

      <div class="toolbar rounded" style="margin-top: -25px;">
        <button class="toolbar-button disabled"><span class="mif-floppy-disk"></span></button>
        <button class="toolbar-button disabled"><span class="mif-print"></span></button>
        <button class="toolbar-button"><span class="mif-pencil"></span></button>
      </div>
		</div>
    </form>
	</body>
</html>