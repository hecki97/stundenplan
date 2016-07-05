<?php
  require('bootstrap.php');
  use Utilities\Dir;
  use Utilities\NetworkUtilities;

  Dir::include_file('Resources.Library.Php.DashboardViewController');
  NetworkUtilities::Redirect_if_not_exists($_SESSION['username'], './login.html');

  $dashboardView = new DashboardViewController();

  // Declaring vars
  $columns = array('index' => '', 'name' => '', 'timestamp' => '');
  $get = array('page' => 0, 'sort' => 'asc', 'column' => 'index', 'view' => 'normal', 'post' => null, 'item_id' => null);
  foreach (array_keys($get) as $key) {
    if (!empty($_GET[$key])) $get[$key] = $_GET[$key];
  }
  $columns[$get['column']] = 'sort-'.$get['sort'];

  if ($get['post'] === 'remove_item' && $get['item_id'] != null) DashboardHandler::Remove_Item($item_id);
  else if ($get['post'] === 'favorite_item' && $get['item_id'] != null) {
    $is_favorite = DashboardHandler::Get_Item_Properties($get['item_id'], array('favorite'));
    $is_favorite['favorite'] = (($is_favorite['favorite'] === 'true') ? 'false' : 'true');
    DashboardHandler::Set_Item_Properties($item_id, $is_favorite);
  }
  
  //Generate list
  $list = $dashboardView->Generate_List($get);

  //Setup div vars to show/hide elements
  $toolbar_toggle_is_editmode = ($get['view'] === 'edit') ? 'disabled' : '';
  $div_display = 'display: '.(!empty($list) ? 'block' : 'none').';';
  $div_popover_display = 'display: '.((isset($_POST['create']) && empty($_POST['tablename'])) ? 'block' : 'none').';';

  function Dashboard_Redirect($values) {
    global $page_count, $get;

    $new_get = $get;
    foreach (array_keys($values) as $key) {
      if (array_key_exists($key, $new_get)) $new_get[$key] = $values[$key];
    }

    if (($new_get['page'] >= 0) && ($new_get['page'] <= $page_count - 1)) header('Refresh:0; url=./dashboard.html?column='.$new_get['column'].'&sort='.$new_get['sort'].'&view='.$new_get['view'].'&page='.$new_get['page']);
  }

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    switch (isset($_POST)) {
      //Create Item
      case isset($_POST['create']):
        if (!empty($_POST['tablename'])) DashboardHandler::Add_Item($_POST['tablename']);
        break;
      //Toolbar Trashbin
      case isset($_POST['toolbar_trashbin']):
        if (!empty($list)) DashboardHandler::Clear_List();
        break;
      //Toolbar Edit
      case isset($_POST['toolbar_wrench']):
        Dashboard_Redirect(array('view' => ($get['view'] === 'normal') ? 'edit' : 'normal'));
        break;
      //Sort Table
      case isset($_POST['column']):
        Dashboard_Redirect(array('column' => $_POST['column'], 'sort' => ($get['sort'] === 'asc') ? 'desc' : 'asc'));
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
    <title><?=_('dashboard-title'); ?></title>
    <script type="text/javascript" src="resources/js/DashboardViewController.js"></script>
    <script type="text/javascript">
      var data, itemsPerPage = 5;
      var page = 0, maxPage = 0;

      window.onload = function() {
        GetDashboardData();
      }

      function FavoriteItem(event) {
        // Get the event (handle MS difference)
        button = event || window.event;

        var jsonString = JSON.stringify([button.parentElement.parentElement.getAttribute('itemID'), button.getAttribute('isFavorite')]);
        $.ajax({
          url: './resources/library/php/ProcessAjaxRequests.php',
          data: { data: jsonString, action: 'FavoriteItem' },
          type: 'post',
          success: function(isFavorite) {
            button.setAttribute('isFavorite', isFavorite);
            button.firstElementChild.className = 'mif-star-' + ((isFavorite === 'true') ? 'full' : 'empty');
          }
        });
      }

      function GetDashboardData() {
        $.ajax({
          url: './resources/library/php/ProcessAjaxRequests.php',
          data: { action: 'GetDashboardData' },
          type: 'post',
          success: function(dashboardData) {
            data = JSON.parse(dashboardData);
            maxPage = parseInt(data.length / itemsPerPage);
            DashboardViewController_GenerateList();
            DashboardViewController_UpdateToolbar();
          }
        });
      }

      function CreateTable() {
        $.ajax({
          url: './resources/library/php/ProcessAjaxRequests.php',
          data: { data: 'Test1', action: 'CreateTable' },
          type: 'post',
          success: function() {
            GetDashboardData();
         }
        });
      }
    </script>
  </head>
  <body>
    <!-- load navbar from navbar.php -->
    <?php require('navbar.php'); ?>
    <div class="page-content">
      <div class="page-header"><?=_('dashboard-page-header'); ?></div>
      <div class="page-content-box content-box-shadow">
      <form method="post">
        <div class="input-control text full-size" data-role="input">
          <span class="mif-table prepend-icon"></span>
          <input type="text" placeholder="<?=_('input-text-timetable-placeholder'); ?>" name="tablename">
          <div class="button-group">
            <button class="button helper-button clear"><span class="mif-cross"></span></button>
            <button class="button" name="create" type="button" onclick="CreateTable();"><?=_('button-create'); ?></button>
          </div> 
        </div>
      </div>
    <div class="popover marker-on-top bg-red fg-grayLighter page-content-popover" style="box-shadow: 7px 7px #4C0000; margin-bottom: 10px; <?=$div_popover_display; ?>">
      <?//=DIV_POPOVER_TEXTFIELD_CANNOT_BE_EMPTY; ?>
    </div>
    <!-- Toolbar -->
    <div class="toolbar rounded" id="toolbar" style="margin-top: 25px; margin-bottom: -5px; <?=$div_display; ?>">
      <button class="toolbar-button" type="button" onclick="DashboardViewController_GotoPage(this);" name="firstPage" title="Go To First Page"><span class="mif-first"></span></button>
      <button class="toolbar-button" type="button" onclick="DashboardViewController_GotoPage(this);" name="fivePagesBack" title="Go 5 Pages Back"><span class="mif-backward"></span></button>
      <button class="toolbar-button" type="button" onclick="DashboardViewController_GotoPage(this);" name="prevPage" title="Go To Previous Page"><span class="mif-previous"></span></button>
      <span style="margin: 0 12.5px 0 12.5px;"></span>
      <button class="toolbar-button" title="Activate/Deactivate Debug Mode" name="toolbar_debug_mode" onclick="return confirm('Do you really want to activate/deactivate debug mode?');"><span class="mif-bug"></span></button>
      <button class="toolbar-button <?=$toolbar_toggle_is_editmode; ?>" style="cursor: pointer;" title="Activate/Deactivate Edit Mode" name="toolbar_wrench" type="submit"><span class="mif-wrench"></span></button>
      <span style="margin: 0 12.5px 0 12.5px;"></span>
      <button class="toolbar-button" id='toolbarCurrentPage' title="Current Page"></button>
      <button class="toolbar-button">of</button>
      <button class="toolbar-button" id="toolbarMaxPage" title="Max Page"></button>
      <span style="margin: 0 12.5px 0 12.5px;"></span>
      <button class="toolbar-button" title="Go to Settings" name="toolbar_settings"><span class="mif-cog"></span></button>
      <button class="toolbar-button" title="Clear Dashboard" name="toolbar_trashbin" onclick="return confirm('Do you really want to remove your list?');"><span class="mif-bin"></span></button>
      <span style="margin: 0 12.5px 0 12.5px;"></span>
      <button class="toolbar-button" type="button" onclick="DashboardViewController_GotoPage(this);" name="nextPage" title="Go To Next Page"><span class="mif-next"></span></button>
      <button class="toolbar-button" type="button" onclick="DashboardViewController_GotoPage(this);" name="fivePagesForward" title="Go 5 Pages Forward"><span class="mif-forward"></span></button>
      <button class="toolbar-button" type="button" onclick="DashboardViewController_GotoPage(this);" name="lastPage" title="Go To Last Page"><span class="mif-last"></span></button>
    </div>
    <!-- Dashboard List -->
    <div class="page-large-content-box content-box-shadow" id="dashboard-table-content-box">
      <table class="table border striped" id="table" align="center"><thead><tr>
          <th class="dashboard-table-column-index sortable-column"><label><?=_('dashboard-table-header-index'); ?><button onclick="DashboardViewController_UpdateTable('INDEX');" name="column" value="index" type="button"></button></label></th>
          <th class="sortable-column"><label><?=_('dashboard-table-header-tablename'); ?><button onclick="DashboardViewController_UpdateTable('NAME');" name="column" value="name" type="button"></button></label></th>
          <th class="dashboard-table-column-date sortable-column"><label><?=_('dashboard-table-header-date'); ?><button onclick="DashboardViewController_UpdateTable('DATE');" name="column" value="timestamp" type="button"></button></label></th>
          <th class='dashboard-table-column-options'><?=_('dashboard-table-header-options'); ?></th>
        </tr></thead>
        <tbody></tbody>
      </table>
    </div>
    <br/>
    <footer><h4><a href="./dashboard.php">PHP Version (deprecated)</a></h4></footer>
    </div>
  </body>
</html>