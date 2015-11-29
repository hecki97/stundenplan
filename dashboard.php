<?php
  session_start();
  require('bootstrap.php');

  FileLoader::Load('Resources.Library.Php.DashboardHandler');
  NetworkUtilities::Redirect_if_not_exists($_SESSION['username'], './login.html');
  NetworkUtilities::Redirect_if_not_exists(@$_GET['sort'], './dashboard_index_asc.html');

  $get = preg_replace('/\_(.*)/', '', $_GET['sort']);
  $edit = (isset($_GET['edit'])) ? $_GET['edit'] : 'false';
  $sort = (preg_replace('/(.*)\_/', '', $_GET['sort']) == 'asc') ? SORT_ASC : SORT_DESC;
  $list = DashboardHandler::Generate_List($get, $sort);

  $sort_status_array = array('index' => '', 'name' => '', 'timestamp' => '');
  switch ($get) {
    case 'name':
      $sort_status_array['name'] = 'sort-'.(($sort == SORT_ASC) ? 'asc' : 'desc');
      break;
    case 'timestamp':
      $sort_status_array['timestamp'] = 'sort-'.(($sort == SORT_ASC) ? 'asc' : 'desc');
      break;
    default:
      $sort_status_array['index'] = 'sort-'.(($sort == SORT_ASC) ? 'asc' : 'desc');
      break;
  }

  $div_edit_display = ($edit == 'true') ? 'disabled' : '';
  $div_display = empty($list) ? 'display: none;' : 'display: block;';
  $div_popover_display = 'display: none;';

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    switch (isset($_POST)) {
      //Create_Table
      case isset($_POST['create']):
        if (!empty($_POST['tablename']))
          DashboardHandler::Save_Tablename($_POST['tablename']);
        else
          $div_popover_display = 'display: block;';
        break;
      //Toolbar
      case isset($_POST['toolbar_trashbin']):
        DashboardHandler::Remove_List();
        break;
      case isset($_POST['toolbar_wrench']):
        $edit = ($edit == 'true') ? 'false' : 'true';
        header('Refresh:0; url=./dashboard.html?sort='.$get.'&edit='.$edit);
        break;
      //Table_Column
      case isset($_POST['column_index']):
        $get = 'index_'.(($sort_status_array['index'] == 'sort-asc') ? 'desc' : 'asc');
        header('Refresh:0; url=./dashboard.html?sort='.$get.'&edit='.$edit);
        // header('Refresh:0; url=./dashboard_'.$get.'.html');
        break;
      case isset($_POST['column_tablename']):
        $get = 'name_'.(($sort_status_array['name'] == 'sort-asc') ? 'desc' : 'asc');
        header('Refresh:0; url=./dashboard.html?sort='.$get.'&edit='.$edit);
        // header('Refresh:0; url=./dashboard_'.$get.'.html');
        break;
      case isset($_POST['column_date']):
        $get = 'timestamp_'.(($sort_status_array['timestamp'] == 'sort-asc') ? 'desc' : 'asc');
        header('Refresh:0; url=./dashboard.html?sort='.$get.'&edit='.$edit);
        // header('Refresh:0; url=./dashboard_'.$get.'.html');
        break;
      //Table_Item
      /*
      case isset($_POST['column_date']):
        DashboardHandler::Remove_List();
        break;
      */
    }
    // if (isset($_POST['column_index']) || isset($_POST['column_index']) || isset($_POST['column_index']))
      // header('Refresh:0; url=./dashboard.html?sort='.$get);
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

       <div class="toolbar rounded" style="margin-top: 25px; margin-bottom: -20px;">
        <button class="toolbar-button <?=$div_edit_display; ?>" style="cursor: pointer;" name="toolbar_wrench"><span class="mif-wrench"></span></button>
        <button class="toolbar-button"><span class="mif-warning"></span></button>
        <button class="toolbar-button" name="toolbar_trashbin" onclick="return confirm('Do you really want to remove your list?');"><span class="mif-bin"></span></button>
      </div>

      <div class="page-large-content-box content-box-shadow" id="dashboard-table-content-box" style="<?=$div_display; ?>">
        <table class="table border striped" align="center">
          <thead>
            <tr>
              <th class="sortable-column <?=$sort_status_array['index']; ?>"><label>Index<button name="column_index" type="submit"></button></label></th>
              <th class="sortable-column <?=$sort_status_array['name']; ?>"><label>Tablename<button name="column_tablename" type="submit"></button></label></th>
              <th class="sortable-column <?=$sort_status_array['timestamp']; ?>"><label>Date<button name="column_date" type="submit"></button></label></th>
              <th>Options</th>
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