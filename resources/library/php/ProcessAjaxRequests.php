<?php
	require_once('../../../bootstrap.php');
	use Utilities\Dir;

	Dir::include_file('Resources.Library.Php.AccountHandler');
	Dir::include_file('Resources.Library.Php.DashboardHandler');
	Dir::include_file('Resources.Library.Php.TableHandler');

	if(isset($_POST['action']) && !empty($_POST['action'])) {
	    switch($_POST['action']) {
	        case 'RegisterUser':
	        	echo AccountHandler::Register_new_user($_POST['data']);
	        	break;
	        case 'LoginUser':
	        	echo AccountHandler::Log_user_in($_POST['data']);
	        	break;
	        case 'GetDashboardData':
	        	echo json_encode(DashboardHandler::Get_Dashboard_Table_Data());
	        	break;
	        case 'CreateTable':
	        	DashboardHandler::Add_Item($_POST['data']);
	        	break;
	        case 'FavoriteItem':
				$data = json_decode($_POST['data']);
				$selected_item = DashboardHandler::Get_Item_Properties($data[0], array('favorite'));
				$selected_item['favorite'] = (($selected_item['favorite'] === 'true') ? 'false' : 'true');
				DashboardHandler::Set_Item_Properties($data[0], $selected_item);
				echo $selected_item['favorite'];
	        	break;
	        default:
	        	die('Action "'.$action.'" was not found!');
	    }
	}
?>