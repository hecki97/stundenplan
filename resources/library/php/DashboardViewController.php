<?php
  use Utilities\Dir;
  use Utilities\Array_Class;
	/**
	* Dashboard View Controller
	*/
	class DashboardViewController
	{
		private $decrypted_data;

		function __construct(){
			Dir::include_file('Resources.Library.Php.DashboardHandler');
			Dir::include_file('Resources.Library.Php.TableHandler');

			$this->decrypted_data = DashboardHandler::Get_Dashboard_Data();
		}

		/**
   		* Generates the list depending on the given operators $column, $sort, $edit and returns the list.
   		* @param string   $column
   		* @param constant $sort
   		* @param boolean  $edit
   		*/
  		public function Generate_List($get) {
    		$sort = ($get['sort'] === 'asc') ? SORT_ASC : SORT_DESC;
        $editmode = ($get['view'] === 'edit') ? true : false;
       
        $list = '';
    		switch ($get['column']) {
      			case 'index':
        			if ($sort === SORT_ASC) {
          				for ($i = $get['page'] * 5; $i < ($get['page'] + 1) * 5/*count($this->decrypted_data)*/; $i++) { 
            				$list .= $this->Generate_Item($i, $editmode);
          				} 
        			}
        			else {
          				for ($i = count($this->decrypted_data) - 1; $i >= 0; $i--) { 
            				$list .= $this->Generate_Item($i, $editmode);
          				} 
        			}
        			break;
      			default:
              var_dump($this->decrypted_data);
        			$this->decrypted_data = Array_Class::Array_Sort($this->decrypted_data, $get['column'], $sort);
        			for ($i = 0; $i < count($this->decrypted_data); $i++) { 
          				$list .= $this->Generate_Item($i, $editmode);
        			}
        		break;
    		}
    		return $list;
  		}

      public function Get_Page_Count() {
        return count($this->decrypted_data);
      }

  		/**
   		* Generates one item depending on the given operaters $i, $edit and then returns it.
   		* @param integer $i    
   		* @param boolean $edit
   		*/
  		private function Generate_Item($i, $edit = false) {
        if (!isset($this->decrypted_data[$i])) return;

    		$item_properties = TableHandler::Load_Table($this->decrypted_data[$i]['id']);
    		$item  = "<tr><th class='dashboard-table-column-index'>".($i + 1).".</th>";
    		$item .= "<th><div class='dashboard-table-column-table-name'>";
    		$item .= "<a href='./dashboard.html?column=index&sort=asc&view=normal&page=1&post=favorite_item&item_id=".$this->decrypted_data[$i]['id']."' class='fav-star button link fg-black'>";
    		$item .= ($this->decrypted_data[$i]['favorite'] === 'true') ? "<span class='mif-star-full'></span>" : "<span class='mif-star-empty'></span>";
    		$item .= "</a>";
    		$item .= ($edit) ? "<div><a class='button disabled' style='display: inline; float: left; top: 8.5px;'><span class='mif-arrow-up'></span></a><a class='button disabled' style='display: inline; float: left; top: 8.5px;'><span class='mif-arrow-down'></span></a></div>" : "";
    		$item .= "<a class='table-name button link full-size fg-black' href='./view_item_".$this->decrypted_data[$i]['id'].".html'>".$item_properties['properties']['tablename']."</a>";
    		$item .= "<p class='is-empty'><i>".(($item_properties['properties']['empty']) ? '(Empty)' : '')."</i></p>";
    		$item .= "</div></th>";
    		$item .= "<th class='dashboard-table-column-date'><i>".'Latest change: '.date('d/m/y', $item_properties['properties']['timestamp'])."</i></th>";
    		$item .= "<th class='dashboard-table-column-options'>";
    		$item .= "<a class='button' href='./edit_item_".$this->decrypted_data[$i]['id'].".html'><span class='mif-pencil'></span></a><a class='button' href='./remove_item_".$this->decrypted_data[$i]['id'].".html'><span class='mif-bin'></span></a></th></tr>";

    		return $item;
  		}
	}
?>