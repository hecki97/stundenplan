// toolbar vars
var toolbarInitialized = false, toolbarItems = Array();
var table, tableInitialized = false;
function DashboardViewController_GenerateList() {
  //var root = document.getElementById('dashboard-table-content-box');
  //var tab = document.createElement('table');
  //tab.className = 'table border striped';
  //var thead = document.createElement('thead');
  //thead.innerHTML = '<tr><th class="dashboard-table-column-index sortable-column sort-asc"><label><?=_('dashboard-table-header-index'); ?><button name="column" value="index" type="submit"></button></label></th><th class="sortable-column"><label><?=_('dashboard-table-header-tablename'); ?><button name="column" value="name" type="submit"></button></label></th><th class="dashboard-table-column-date sortable-column "><label><?=_('dashboard-table-header-date'); ?><button name="column" value="timestamp" type="submit"></button></label></th><th class="dashboard-table-column-options"><?=_('dashboard-table-header-options'); ?></th></tr>';
  //var tbody = document.createElement('tbody');
  if (!tableInitialized) {
    table = document.getElementById('table').children;
    tableInitialized = true;
  }
  var tbody = table[1];
  tbody.innerHTML = '';
  var row, cell;
  for(var i = page * itemsPerPage; i < (page + 1) * itemsPerPage /*data.length*/; i++){
    row = document.createElement('tr');
    if (typeof data[i] === 'undefined') continue;
    row.setAttribute('itemID', data[i].id);
    for( var j = 0; j < 4; j++) {
      cell = document.createElement('td');
      switch (j) {
        case 0:
          cell.className = 'dashboard-table-column-index';
          cell.appendChild(document.createTextNode(data[i].index + '.'));
          break;
        case 1:
          cell.className = 'dashboard-table-column-table-name';
          var favStar = document.createElement('a');
          favStar.className = 'fav-star button link fg-black';
          favStar.setAttribute('isFavorite', data[i].favorite);
          //favStar.href = './dashboard-js.html?column=index&sort=asc&view=normal&page=1&post=favorite_item&item_id=' + data[i].id;
          favStar.onclick = function() { FavoriteItem(this); };
          favStar.innerHTML = (data[i].favorite === 'true') ? "<span class='mif-star-full'></span>" : "<span class='mif-star-empty'></span>";
          cell.appendChild(favStar);
          var tableName = document.createElement('a');
          tableName.className = 'table-name button link full-size fg-black';
          tableName.href = './view-js.html?id=' + data[i].id;
          tableName.innerHTML = data[i].properties.tablename;
          cell.appendChild(tableName);
          var isEmpty = document.createElement('p');
          isEmpty.className = 'is-empty';
          isEmpty.setAttribute('isEmpty', data[i].properties.empty);
          isEmpty.innerHTML = '<i>' + ((data[i].properties.empty) ? '(Empty)' : '') + '</i>';
          cell.appendChild(isEmpty);
          //cell.innerHTML = "<a href='./dashboard.html?column=index&sort=asc&view=normal&page=1&post=favorite_item&item_id=" + data[i].id + "' class='fav-star button link fg-black'>" + ((data[i].favorite === 'true') ? "<span class='mif-star-full'></span>" : "<span class='mif-star-empty'></span>") + "</a><a class='table-name button link full-size fg-black' href='./view_item_" + data[i].id + ".html'>" + data[i].properties.tablename + "</a>" + "<p class='is-empty'><i>" + ((data[i].properties.empty) ? '(Empty)' : '') + "</i></p>";
          break;
        case 2:
          cell.className = 'dashboard-table-column-date';
          var date = new Date(data[i].properties.timestamp * 1000);
          cell.innerHTML = '<i>Latest change: ' + ("0" + date.getDate()).slice(-2) + '/' + ("0" + (date.getMonth() + 1)).slice(-2) + '/' + date.getFullYear() + '</i>';
          break;
        case 3:
          cell.innerHTML = "<a class='button' href='./edit_item_" + data[i].id + ".html'><span class='mif-pencil'></span></a><a class='button' href='./remove_item_" + data[i].id + ".html'><span class='mif-bin'></span></a>";
          break;
        default:
          cell.innerHTML = "Oops something bad happened!";
          break;
      }
      row.appendChild(cell);
    }
    tbody.appendChild(row);
    //tab.appendChild(thead);
    //tab.appendChild(tbody);
    //root.appendChild(tab);
  }
}

function DashboardViewController_UpdateToolbar() {
  if (!toolbarInitialized) {
    var toolbar = document.getElementById('toolbar').childNodes;
    for (var i = 0; i < toolbar.length; i++) {
      if (toolbar[i].tagName === 'BUTTON') toolbarItems.push(toolbar[i]);
    }
    toolbarInitialized = true;
  }
  // toolbar button goto first page
  toolbarItems[0].className = (page <= 0) ? toolbarItems[0].className + ' disabled' : toolbarItems[0].className.replace(/disabled/, '');
  // toolbar button go five pages back
  toolbarItems[1].className = (page - 5 < 0) ? toolbarItems[1].className + ' disabled' : toolbarItems[1].className.replace(/disabled/, '');
  // toolbar button goto previous page
  toolbarItems[2].className = (page <= 0) ? toolbarItems[2].className + ' disabled' : toolbarItems[2].className.replace(/disabled/, '');
  // toolbar current page
  toolbarItems[5].innerHTML = page + 1;
  // toolbar max page
  toolbarItems[7].innerHTML = maxPage + 1;
  // toolbar button goto next page
  toolbarItems[10].className = (page >= maxPage) ? toolbarItems[10].className + ' disabled' : toolbarItems[10].className.replace(/disabled/, '');
  // toolbar button go five pages forward
  toolbarItems[11].className = (page + 5 > maxPage) ? toolbarItems[11].className + ' disabled' : toolbarItems[11].className.replace(/disabled/, '');
  // toolbar button goto last page
  toolbarItems[12].className = (page >= maxPage) ? toolbarItems[12].className + ' disabled' : toolbarItems[12].className.replace(/disabled/, '');
}

function DashboardViewController_GotoPage(event) {
  var buttonName = event.name;
  var newPage = 0;
  switch (buttonName) {
    case 'firstPage':
      newPage = 0;
      break;
    case 'fivePagesBack':
      newPage = page - 5;
      break;
    case 'prevPage':
      newPage = page - 1;
      break;
    case 'nextPage':
      newPage = page + 1;
      break;
    case 'fivePagesForward':
      newPage = page + 5;
      break;
    case 'lastPage':
      newPage = maxPage;
      break;
  }
  if (newPage < 0 || newPage > maxPage) return;
  page = newPage;
  DashboardViewController_UpdateToolbar();
  DashboardViewController_GenerateList();
}

var indexState = 'ASC', nameState = 'ASC', dateState = 'ASC';
function DashboardViewController_UpdateTable(sortState) {
  var thead = table[0].children[0].children;
  if (data.length <= 0) return;
  switch (sortState) {
    case 'INDEX':
      indexState = InvertSortingOrder(indexState);
      ArraySort('index', indexState);
      //thead[0].className = thead[0].className + (indexState === 'ASC') ? thead[0].className.replace(/sort-asc/, ' sort-desc') : thead[0].className.replace(/sort-desc/, ' sort-asc');
      break;
    case 'NAME':
      nameState = InvertSortingOrder(nameState);
      ArraySort('tablename', nameState);
      break;
    case 'DATE':
      dateState = InvertSortingOrder(dateState);
      ArraySort('timestamp', dateState);
      break;
    default:
      ArraySort('index', 'ASC');
      break;
  }
  DashboardViewController_GenerateList();
}

function InvertSortingOrder(sortState) {
  return (sortState === 'ASC') ? 'DESC' : 'ASC';
}

function ArraySort(key, order) {
  var keyArray = new Array(), sortableArray = new Array(), newArray = new Array();
  var isProperty = false;

  for (var i = 0; i < data.length; i++) {
    if (data[i][key] == null) {
      if (data[i]['properties'][key] != null) {
        keyArray.push(data[i]['properties'][key]);
        sortableArray.push(data[i]['properties'][key]);
        isProperty = true;
      }
      else
        console.error('"' + key + '" was not found in Array; index: ' + i + '!');
    }
    else {
      keyArray.push(data[i][key]);
      sortableArray.push(data[i][key]);
    }
  }
  (order === 'DESC') ? sortableArray.sort().reverse() : sortableArray.sort();
  for (var i = 0; i < data.length; i++) {
    var index = keyArray.indexOf(sortableArray[i]);
    newArray[i] = data[index];
    if (isProperty)
      newArray[i]['properties'][key] = sortableArray[i];
    else 
      newArray[i][key] = sortableArray[i];
  }
  data = newArray;
}