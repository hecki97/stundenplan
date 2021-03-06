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
	<script type="text/javascript">
		function rgb2hex(rgb) {
		    if (/^#[0-9A-F]{6}$/i.test(rgb)) return rgb;
		    rgb = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
		    
		    function hex(x) {
		        return ("0" + parseInt(x).toString(16)).slice(-2);
		    }
		    return "#" + hex(rgb[1]) + hex(rgb[2]) + hex(rgb[3]);
		}

		function switchValue(event) {
			var button, otherButton, buttonIndex, buttonType,
				parentElement, bgColor;

			// Get the event (handle MS difference)
		    button = event || window.event;

		    // Execute only when 'disabled' was not found
		    if (button.className.indexOf("disabled") === -1) {
		    	buttonName = button.name.split("_");
		    	buttonIndex = buttonName[1];
		    	buttonType = buttonName[2];
		    	
		    	parentElement = document.getElementById(buttonIndex);
		    	bgColor = parentElement.style.backgroundColor;

		    	parentElement.firstChild.innerHTML = ((buttonType === 'hex') ? "HEX" : "RGB") + " <span name='color_" +  buttonIndex + "_" + buttonType + "' title='Click to edit!' class='color-string'>" + ((buttonType === 'hex') ? rgb2hex(bgColor) : bgColor) + "</span>";
		    	button.className += " disabled";
		    	
		    	var invertedButtonType = (buttonType === 'hex') ? "rgb" : "hex";
		    	otherButton = document.getElementsByName("button_" + buttonIndex + "_" + invertedButtonType)[0];
		    	otherButton.setAttribute("class", otherButton.className.replace(/disabled/, ""));
		    }
		}

		//Test

		/* Accept:
		**   number triplets: xxx,xxx,xxx
		**   rgb values     : rgb(xxx,xxx,xxx)
		**   Hex values     : xxxxxx and xxxx
		**   prefixed hex   : #xxxxxx and #xxx
		*/
		function parseColourString(string) {

		  // Tokenise input
		  var match = string.match(/^\#|^rgb\(|[\d\w]+$|\d{3}/g);

		  // Other variables
		  var value, values;
		  var valid = true, double = false, hex = false;

		  // If no matches, return false
		  //if (!match) return false;

		  hex = (match.length < 3) ? true : false;

		  // If hex value
		  if (hex) {

		    // Get the value
		    value = match[match.length-1];

		    // Split into parts, either x,x,x or xx,xx,xx
		    values = value.length == 3? double = true && value.split('') : value.match(/../g);

		    // Convert to decimal values - if #nnn, double up on values 345 => 334455
		    values.forEach(function(v,i){values[i] = parseInt(double? ''+v+v : v, 16);});

		  // Otherwise it's rgb, get the values
		  } else {
		    values = match.length == 3? match.slice() : match.slice(1);
		  }

		  // Check that each value is between 0 and 255 inclusive and return the result
		  values.forEach(function(v) { valid = valid ? v >= 0 && v <= 255 : false; });

		  var type = (hex) ? 'hex' : 'rgb';
		  var string = (hex) ? ((string.indexOf('#') == -1) ? ('#' + string) : string) : values.toString(); 
		  return valid && Array(string, type); 

		  // If string is invalid, return false, otherwise return an array of the values
		  //return valid && values;
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
		    		buttonAttributes = span.getAttribute("name").split("_");
		    		itemIndex = buttonAttributes[1];
		    		itemType = buttonAttributes[2];

		      		// Hide it
		      		span.style.display = "none";
		      		// Get its text
		      		text = span.innerHTML;

		      		// Create an input
		      		input = document.createElement("input");
		      		input.type = "text";
		      		input.size = Math.max(text.length / 4 * 3, 4);
		      		input.maxLength = (itemType === "hex") ? "7" : "16";
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
		        			var string = parseColourString(input.value);
		        			if (string != false) document.getElementById(itemIndex).style.background = string[0];
		        			span.style.color = (string !== false) ? "#000" : "#ff0000";
		        			span.innerText = (string !== false) ? string[0] : input.value;
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