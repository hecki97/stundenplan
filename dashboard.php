<?php
  require('bootstrap.php');
  use Utilities\Dir;
  use Utilities\NetworkUtilities;

  Dir::include_file('Resources.Library.Php.DashboardViewController');

  $dashboardView = new DashboardViewController();

  // url scheme
  // localhost/stundenplan/dashboard.html?column=index&sort=asc&view=normal&page=1&post=null&item_id=0
  if (empty($_GET)) {
    header('Refresh:0; url=./dashboard.html?column=index&sort=asc&view=normal&page=0');
    echo('</br> Redirecting...');
    die();
  }  

  // Declaring vars
  $columns = array('index' => '', 'name' => '', 'timestamp' => '');
  $get = array('page' => 0, 'sort' => 'asc', 'column' => 'index', 'view' => 'normal', 'post' => null, 'item_id' => null);
  foreach (array_keys($get) as $key) {
    if (!empty($_GET[$key])) $get[$key] = $_GET[$key];
  }
  $page_count = (int) ($dashboardView->Get_Page_Count() / 5) + 1;
  $max_page = $page_count - 1;
  $columns[$get['column']] = 'sort-'.$get['sort'];

  if ($get['post'] === 'remove_item' && $get['item_id'] != null) DashboardHandler::Remove_Item($item_id);
  else if ($get['post'] === 'favorite_item' && $get['item_id'] != null) {
    $is_favorite = DashboardHandler::Get_Item_Properties($get['item_id'], array('favorite'));
    $is_favorite['favorite'] = (($is_favorite['favorite'] === 'true') ? 'false' : 'true');
    DashboardHandler::Set_Item_Properties($item_id, $is_favorite);
  }
  NetworkUtilities::Redirect_if_not_exists($_SESSION['username'], './login.html');
  
  //Generate list
  $list = $dashboardView->Generate_List($get);

  //Setup div vars to show/hide elements
  $toolbar_toggle_is_editmode = ($get['view'] === 'edit') ? 'disabled' : '';
  $toolbar_toggle_is_first_page = ($get['page'] <= 0) ? 'disabled' : ''; 
  $toolbar_toggle_is_last_page = ($get['page'] >= $page_count - 1) ? 'disabled' : '';
  $div_display = 'display: '.(!empty($list) ? 'block' : 'none').';';
  $div_popover_display = 'display: '.((isset($_POST['create']) && empty($_POST['tablename'])) ? 'block' : 'none').';';
  $page_display = (($get['page'] + 1 <= 999) ? $get['page'] + 1 : '999+');

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
      case isset($_POST['goto_first_page']):
        Dashboard_Redirect(array('page' => 0));
        break;
      case isset($_POST['go_5_pages_backwards']):
        $page = $get['page'] - 5;
        Dashboard_Redirect(array('page' => ($page >= 0) ? $page : 0));
        break;
      case isset($_POST['goto_prev_page']):
        Dashboard_Redirect(array('page' => ($get['page'] - 1)));
        break;
      case isset($_POST['goto_next_page']):
        Dashboard_Redirect(array('page' => ($get['page'] + 1)));
        break;
      case isset($_POST['go_5_pages_forward']):
        $page = $get['page'] + 5;
        Dashboard_Redirect(array('page' => ($page <= $max_page) ? $page : $max_page));
        break;
      case isset($_POST['goto_last_page']):
        Dashboard_Redirect(array('page' => $max_page));
        break;  
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
            <button class="button" name="create" type="submit"><?=_('button-create'); ?></button>
          </div> 
        </div>
      </div>
      <div class="popover marker-on-top bg-red fg-grayLighter page-content-popover" style="box-shadow: 7px 7px #4C0000; margin-bottom: 10px; <?=$div_popover_display; ?>">
        <?=DIV_POPOVER_TEXTFIELD_CANNOT_BE_EMPTY; ?>
      </div>

      <!-- Toolbar -->
      <div class="toolbar rounded" style="margin-top: 25px; margin-bottom: -5px; <?=$div_display; ?>">
        <button class="toolbar-button <?=$toolbar_toggle_is_first_page; ?>" title="Go To First Page" name="goto_first_page" type="submit"><span class="mif-first"></span></button>
        <button class="toolbar-button <?=$toolbar_toggle_is_first_page; ?>" title="Go 5 Pages Back" name="go_5_pages_backwards" type="submit"><span class="mif-backward"></span></button>
        <button class="toolbar-button <?=$toolbar_toggle_is_first_page; ?>" title="Go To Previous Page" name="goto_prev_page" type="submit"><span class="mif-previous"></span></button>
        <span style="margin: 0 12.5px 0 12.5px;"></span>
        <button class="toolbar-button" title="Activate/Deactivate Debug Mode" name="toolbar_debug_mode" onclick="return confirm('Do you really want to activate/deactivate debug mode?');"><span class="mif-bug"></span></button>
        <button class="toolbar-button <?=$toolbar_toggle_is_editmode; ?>" style="cursor: pointer;" title="Activate/Deactivate Edit Mode" name="toolbar_wrench" type="submit"><span class="mif-wrench"></span></button>
        <span style="margin: 0 12.5px 0 12.5px;"></span>
        <button class="toolbar-button" title="Current Page"><?=$page_display; ?></button>
        <button class="toolbar-button">of</button>
        <button class="toolbar-button" title="Max Page"><?=$page_count; ?></button>
        <span style="margin: 0 12.5px 0 12.5px;"></span>
        <button class="toolbar-button" title="Go to Settings" name="toolbar_settings"><span class="mif-cog"></span></button>
        <button class="toolbar-button" title="Clear Dashboard" name="toolbar_trashbin" onclick="return confirm('Do you really want to remove your list?');"><span class="mif-bin"></span></button>
        <span style="margin: 0 12.5px 0 12.5px;"></span>
        <button class="toolbar-button <?=$toolbar_toggle_is_last_page; ?>" title="Go To Next Page" name="goto_next_page" type="submit"><span class="mif-next"></span></button>
        <button class="toolbar-button <?=$toolbar_toggle_is_last_page; ?>" title="Go 5 Pages Forward" name="go_5_pages_forward" type="submit"><span class="mif-forward"></span></button>
        <button class="toolbar-button <?=$toolbar_toggle_is_last_page; ?>" title="Go To Last Page" name="goto_last_page" type="submit"><span class="mif-last"></span></button>
      </div>

      <!-- Dashboard List -->
      <div class="page-large-content-box content-box-shadow" id="dashboard-table-content-box" style="<?=$div_display; ?>">
        <table class="table border striped" align="center">
          <thead>
            <tr>
              <th id='dashboard-table-column-index' class="sortable-column <?=$columns['index']; ?>"><label><?=_('dashboard-table-header-index'); ?><button name="column" value="index" type="submit"></button></label></th>
              <th class="sortable-column <?=$columns['name']; ?>"><label><?=_('dashboard-table-header-tablename'); ?><button name="column" value="name" type="submit"></button></label></th>
              <th id='dashboard-table-column-date' class="sortable-column <?=$columns['timestamp']; ?>"><label><?=_('dashboard-table-header-date'); ?><button name="column" value="timestamp" type="submit"></button></label></th>
              <th id='dashboard-table-column-options'><?=_('dashboard-table-header-options'); ?></th>
            </tr>
          </thead>
          <tbody>
            <?=$list ?>
          </tbody>
        </table>
      </div>
      </form>
      <br/>
      <footer>
      <h4><a href="./dashboard-js.php">Javascript Version</a></h4>
      </footer>
    </div>
  </body>
</html>