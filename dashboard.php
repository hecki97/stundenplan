<?php
  require('bootstrap.php');

  FileLoader::Load('Resources.Library.Php.DashboardHandler');
  if (isset($_GET['remove'])) DashboardHandler::Remove_Item_from_List($_GET['remove']);
  NetworkUtilities::Redirect_if_not_exists($_SESSION['username'], './login.html');
  NetworkUtilities::Redirect_if_not_exists(@$_GET['sort'], './dashboard_index_asc.html');

  //Setup vars from url
  $url_get_column = preg_replace('/\_(.*)/', '', $_GET['sort']);
  $url_get_sort = preg_replace('/(.*)\_/', '', $_GET['sort']);
  $url_get_edit = (isset($_GET['edit'])) ? $_GET['edit'] : 'false';

  //Generate list
  $list = DashboardHandler::Generate_List($url_get_column, ($url_get_sort == 'asc') ? SORT_ASC : SORT_DESC, ($url_get_edit == 'true') ? true : false);

  $column_status_array = array('index' => '', 'name' => '', 'timestamp' => '');
  $column_status_array[$url_get_column] = 'sort-'.$url_get_sort;

  //Setup div vars to show/hide some elements
  $div_edit_display = ($url_get_edit == 'true') ? 'disabled' : '';
  $div_display = empty($list) ? 'display: none;' : 'display: block;';
  $div_popover_display = 'display: none;';

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    switch (isset($_POST)) {
      //Create Item
      case isset($_POST['create']):
        if (!empty($_POST['tablename']))
          DashboardHandler::Add_Item($_POST['tablename']);
        else
          $div_popover_display = 'display: block;';
        break;
      //Toolbar Trashbin
      case isset($_POST['toolbar_trashbin']):
        DashboardHandler::Clear_List();
        break;
      //Toolbar Edit
      case isset($_POST['toolbar_wrench']):
        $edit = ($url_get_edit == 'true') ? 'false' : 'true';
        header('Refresh:0; url=./dashboard.html?sort=index_asc&edit='.$edit);
        break;
      //Sort Table
      case isset($_POST['column']):
        $sort = ($url_get_column == $_POST['column']) ? (($url_get_sort == 'asc') ? 'desc' : 'asc') : 'asc';
        $get = ($_POST['column']).'_'.$sort;
        header('Refresh:0; url=./dashboard_'.$get.'.html');
        break;
    }
  }
?>
<!-- HTML Code -->
<!DOCTYPE html>
<html>
  <head>
    <!-- load header from header.php -->
    <?php require('header.php'); ?>
    <title><?=DASHBOARD_TITLE; ?></title>
  </head>
  <body>
    <!-- load navbar from navbar.php -->
    <?php require('navbar.php'); ?>
    <div class="page-content" style="max-height: 100%;">
      <div class="page-header"><?=DASHBOARD_PAGE_HEADER; ?></div>
      <div class="page-content-box content-box-shadow">
      <form method="post">
        <div class="input-control text full-size" data-role="input">
          <span class="mif-table prepend-icon"></span>
          <input type="text" placeholder="<?=INPUT_TEXT_TIMETABLE_PLACEHOLDER; ?>" name="tablename">
          <div class="button-group">
            <button class="button helper-button clear"><span class="mif-cross"></span></button>
            <button class="button" name="create" type="submit"><?=BUTTON_CREATE; ?></button>
          </div> 
        </div>
      </div>
      <div class="popover marker-on-top bg-red fg-grayLighter page-content-popover" style="box-shadow: 7px 7px #4C0000; margin-bottom: 10px; <?=$div_popover_display; ?>">
        <?=DIV_POPOVER_TEXTFIELD_CANNOT_BE_EMPTY; ?>
      </div>

       <div class="toolbar rounded" style="margin-top: 25px; margin-bottom: -5px;">
        <button class="toolbar-button <?=$div_edit_display; ?>" style="cursor: pointer;" name="toolbar_wrench" type="submit"><span class="mif-wrench"></span></button>
        <button class="toolbar-button"><span class="mif-warning"></span></button>
        <button class="toolbar-button" name="toolbar_trashbin" onclick="return confirm('Do you really want to remove your list?');"><span class="mif-bin"></span></button>
      </div>

      <div class="page-large-content-box content-box-shadow" id="dashboard-table-content-box" style="<?=$div_display; ?>">
        <table class="table border striped" align="center">
          <thead>
            <tr>
              <th class="sortable-column <?=$column_status_array['index']; ?>"><label><?=TABLE_HEADER_INDEX; ?><button name="column" value="index" type="submit"></button></label></th>
              <th class="sortable-column <?=$column_status_array['name']; ?>"><label><?=TABLE_HEADER_TABLENAME; ?><button name="column" value="name" type="submit"></button></label></th>
              <th class="sortable-column <?=$column_status_array['timestamp']; ?>"><label><?=TABLE_HEADER_DATE; ?><button name="column" value="timestamp" type="submit"></button></label></th>
              <th><?=TABLE_HEADER_OPTIONS; ?></th>
            </tr>
          </thead>
          <tbody>
            <?=$list ?>
          </tbody>
        </table>
      </div>
      </form>
    </div>
  </body>
</html>