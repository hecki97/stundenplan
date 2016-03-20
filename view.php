<!-- PHP Code -->
<?php
  require('bootstrap.php');

  FileLoader::Load('Resources.Library.Php.TableViewController');

  $view = (!isset($_GET['view'])) ? 'table' : 'other';
  $tableView = new TableViewController($_GET['id'], @$_GET['view'] == 'edit');

  $toolbar = array('table' => array('0' => array('title' => 'Edit', 'name' => 'edit', 'icon' => 'mif-pencil'), '1' => array('title' => 'Preferences', 'name' => 'preferences', 'icon' => 'mif-tools'), '2' => array('title' => 'Color', 'name' => 'color', 'icon' => 'mif-paint')), 'other' => array('0' => array('title' => 'Save', 'name' => 'save', 'icon' => 'mif-floppy-disk'), '1' => array('title' => 'Table', 'table' => 'reload', 'icon' => 'mif-table'), '2' => array('title' => 'Cancel', 'name' => 'cancel', 'icon' => 'mif-cross')));

  switch (@$_GET['view']) {
    case 'color':
      $table = $tableView->Generate_ColorTableView();
      break;
    default:
      $table = $tableView->Generate_TableView();
      break;
  }

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['toolbar-save'])) {
      $tableView->Save_TableView();
    }
    else if (isset($_POST['toolbar-edit'])) {
      header('Refresh:0; url=./edit_item_'.$_GET['id'].'.html');
    }
    else if (isset($_POST['toolbar-color'])) {
      header('Refresh:0; url=./view.php?id='.$_GET['id'].'&view=color');
    }
    else
      header('Refresh:0; url=./view_item_'.$_GET['id'].'.html');
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
      <div class="page-header"><?=$tableView->table_name; ?></div>

      <!--
      <div id="container" style="<?=$div_content_box_display; ?>">
        <div class="page-content-box content-box-shadow">
          <div class="input-control text full-size" data-role="input">
            <span class="mif-table prepend-icon"></span>
            <input type="text" placeholder="Tablename" name="tablename" value="<?//=$tableView->table_name; ?>">
            <button class="button helper-button clear"><span class="mif-cross"></span></button>
          </div>
          Width: <input type="text" placeholder="Width" maxlength="2" size="7" min="0" step="1" name="width" value="<?//=$tableView->table_width; ?>" />
          Height: <input type="text" placeholder="Height" maxlength="2" size="7" min="0" step="1" name="height" value="<?//=$tableView->table_height; ?>" /><br/>
          <input type="submit" name="save" value="Save!" style="height: 25px; margin-top: 10px;" />
          <input type="submit" name="cancel" value="Cancel!" style="height: 25px; margin-top: 10px;" />
        </div>
      </div>
      -->
      
      <div class="page-content-box content-box-shadow" style="padding: 10px 10px 10px 10px; margin-top: 15px;">
        <div class="toolbar rounded">
          <button type="submit" title="<?=$toolbar[$view][0]['title']; ?>" name="toolbar-<?=$toolbar[$view][0]['name']; ?>" class="toolbar-button"><span class="<?=$toolbar[$view][0]['icon']; ?>"></span></button>
          <button type="submit" title="<?=$toolbar[$view][1]['title']; ?>" name="toolbar-<?=$toolbar[$view][1]['name']; ?>" class="toolbar-button"><span class="<?=$toolbar[$view][1]['icon']; ?>"></span></button>
          <button type="submit" title="<?=$toolbar[$view][2]['title']; ?>" name="toolbar-<?=$toolbar[$view][2]['name']; ?>" class="toolbar-button"><span class="<?=$toolbar[$view][2]['icon']; ?>"></span></button>
        </div>
      </div>
      <hr class="line" style="margin-top: -22.5px;" />

			<div class="table-container content-box-shadow" style="width: 90%;">
        <?=$table; ?>
      </div>
		</div>
    </form>
	</body>
</html>