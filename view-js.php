<!-- TODO: Porting PHP Code over to JavaScript -->
<!-- PHP Code -->
<?php
  require('bootstrap.php');
  use Utilities\NetworkUtilities;
  use Utilities\Dir;

  NetworkUtilities::Redirect_if_not_exists($_SESSION['username'], './login.html');
  Dir::include_file('Resources.Library.Php.TableViewController');

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
      header('Refresh:0; url=./view-js.html?id='.$_GET['id'].'&view=color');
    }
    else
      header('Refresh:0; url=./view-js.html?id='.$_GET['id']);
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
	<script type="text/javascript" src="resources/library/js/randomColor.js"></script>
	<script type="text/javascript">
		function GenerateRandomColor(event) {
			// Get the event (handle MS difference)
		   	var button = event || window.event;

		   	var rootElement = button.parentElement.parentElement;
			var color = randomColor({ luminosity: 'dark', hue: 'random' });
			var buttonType = rootElement.firstChild.firstChild.innerText.substring(0, 3);
		
			rootElement.firstChild.style.backgroundColor = color;
			rootElement.firstChild.firstChild.children[0].innerText = (buttonType === "HEX") ? color : Hex2RGB(color);
		}

		Hex2RGB = function(hex) {
			hex = (hex.lastIndexOf('#') > -1) ? hex.replace(/#/, '0x') : '0x' + hex;
		    return "rgb(" + (hex >> 16) + ", " + ((hex & 0x00FF00) >> 8) + ", " + (hex & 0x0000FF) + ")";
		};

		RGB2Hex = function(rgb) {
		    if (/^#[0-9A-F]{6}$/i.test(rgb)) return rgb;
		    rgb = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);

		    function hex(x) {
		        return ("0" + parseInt(x).toString(16)).slice(-2);
		    }
		    return "#" + hex(rgb[1]) + hex(rgb[2]) + hex(rgb[3]);
		}

		function SwitchColorString(event) {
			// Get the event (handle MS difference)
		    var button = event || window.event;

		    // Execute only when 'disabled' was not found
		    if (button.className.indexOf("disabled") === -1) {
		    	var infoElement = button.parentElement;
		    	var circleElement = infoElement.parentElement.firstChild;

		    	var buttonType = button.innerText;
		    	var bgColor = circleElement.style.backgroundColor;

		    	circleElement.firstChild.innerHTML = buttonType + " <span title='Click to edit!' class='color-string'>" + ((buttonType === 'HEX') ? RGB2Hex(bgColor) : bgColor) + "</span>";
		    	button.className += " disabled";

		    	var otherButton = infoElement.children[(buttonType === "HEX") ? 2 : 1];
		    	otherButton.setAttribute("class", otherButton.className.replace(/disabled/, ""));
		    }
		}

		window.onload = function() {
	  		document.getElementById('js-container').onclick = function(event) {
		    	var span, input, text, itemIndex, itemType;

		    	// Get the event (handle MS difference)
		    	event = event || window.event;
		    	// Get the root element of the event (handle MS difference)
		    	span = event.target || event.srcElement;

		    	// If it's a span...
		    	if (span && span.tagName.toUpperCase() === "SPAN" && span.className === "color-string") {
		    		var buttonType = span.parentElement.innerText.substring(0, 3);

		      		// Hide it
		      		span.style.display = "none";
		      		// Get its text
		      		text = span.innerHTML;

		      		// Create an input
		      		input = document.createElement("input");
		      		input.type = "text";
		      		input.size = Math.max(text.length / 4 * 3, 4); //rgb max length 12
		      		input.maxLength = (buttonType === "HEX") ? "7" : "18";
		      		input.style.height = "20px";
		      		input.style.marginTop = "-1.5px";
		      		span.parentNode.insertBefore(input, span);

		      		// Focus it, hook blur to undo
		      		input.focus();
		      		input.onblur = function() {
		        		// Remove the input
		        		span.parentNode.removeChild(input);
		        		// Update the span
		        		if (input.value.length > 0) {
		        			var matchColorsRGB = /^rgb\(\s*(0|[1-9]\d?|1\d\d?|2[0-4]\d|25[0-5])%?\s*,\s*(0|[1-9]\d?|1\d\d?|2[0-4]\d|25[0-5])%?\s*,\s*(0|[1-9]\d?|1\d\d?|2[0-4]\d|25[0-5])%?\s*\)$/;
						    var matchColorsHex = /^#[0-9a-f]{3}([0-9a-f]{3})?$/;
						    
						    if (matchColorsRGB.test(input.value) || matchColorsHex.test(input.value)) {
						    	span.parentElement.parentElement.style.background = input.value;
						    	span.style.color = "#000";
						    } else {
						    	span.style.color = "#f00";
						    }
						    span.innerText = input.value;
		        			span.style.fontStyle = "italic";
		        		}
		        		// Show the span again
		        		span.style.display = "";
		      		};
		    	}
	  		};
		};
	</script>
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