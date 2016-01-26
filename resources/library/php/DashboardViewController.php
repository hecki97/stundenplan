<?php
	/**
	* Dashboard View Controller
	*/
	class DashboardViewController
	{
		private $decrypted_data_array;

		function __construct(){
			FileLoader::Load('Resources.Library.Php.DashboardHandler');
			FileLoader::Load('Resources.Library.Php.TableHandler');

			$this->decrypted_data_array = DashboardHandler::Get_Dashboard_Data();
		}

		/**
   		* Generates the list depending on the given operators $column, $sort, $edit and returns the list.
   		* @param string   $column
   		* @param constant $sort
   		* @param boolean  $edit
   		*/
  		public function Generate_List($column, $sort, $edit = false) {
    		$list = '';
    		switch ($column) {
      			case 'index':
        			if ($sort === SORT_ASC) {
          				for ($i = 0; $i < count($this->decrypted_data_array); $i++) { 
            				$list .= $this->Generate_Item($i, $edit);
          				} 
        			}
        			else {
          				for ($i = count($this->decrypted_data_array) - 1; $i >= 0; $i--) { 
            				$list .= $this->Generate_Item($i, $edit);
          				} 
        			}
        			break;
      			default:
        			$this->decrypted_data = Array_Class::Array_Sort($this->decrypted_data_array, $column, $sort);
        			for ($i = 0; $i < count($this->decrypted_data_array); $i++) { 
          				$list .= $this->Generate_Item($i, $edit);
        			}
        		break;
    		}
    		return $list;
  		}

  		/**
   		* Generates one item depending on the given operaters $i, $edit and then returns it.
   		* @param integer $i    
   		* @param boolean $edit
   		*/
  		private function Generate_Item($i, $edit = false) {
    		$item_properties = TableHandler::Load_Table($this->decrypted_data_array[$i]['id']);

    		$item  = "<tr><th id='dashboard-table-column-index'>".($i + 1).".</th>";
    		$item .= "<th><div id='dashboard-table-column-table-name'>";
    		$item .= "<a href='./dashboard.html?favorite=".$this->decrypted_data_array[$i]['id']."' class='button link fg-black' id='fav-star'>";
    		$item .= ($this->decrypted_data_array[$i]['favorite'] === 'true') ? "<span class='mif-star-full'></span>" : "<span class='mif-star-empty'></span>";
    		$item .= "</a>";
    		$item .= ($edit) ? "<div><a class='button disabled' style='display: inline; float: left; top: 8.5px;'><span class='mif-arrow-up'></span></a><a class='button disabled' style='display: inline; float: left; top: 8.5px;'><span class='mif-arrow-down'></span></a></div>" : "";
    		$item .= "<a class='button link full-size fg-black' id='table-name' href='./view_item_".$this->decrypted_data_array[$i]['id'].".html'>".$item_properties['properties']['tablename']."</a>";
    		$item .= "<p id='is-empty'><i>".(($item_properties['properties']['empty']) ? '(Empty)' : '')."</i></p>";
    		$item .= "</div></th>";
    		$item .= "<th id='dashboard-table-column-date'><i>".'Latest change: '.date('d/m/y', $item_properties['properties']['timestamp'])."</i></th>";
    		$item .= "<th id='dashboard-table-column-options'>";
    		$item .= "<a class='button' href='./edit_item_".$this->decrypted_data_array[$i]['id'].".html'><span class='mif-pencil'></span></a><a class='button' href='./remove_item_".$this->decrypted_data_array[$i]['id'].".html'><span class='mif-bin'></span></a></th></tr>";

    		return $item;
  		}
	}
?>