<?php
use \Colors\RandomColor;

/**
* TableViewController
*/
class TableViewController
{
	public $table_name;
	public $table_width;
	public $table_height;

	private $table_id;
	private $table_edit_mode;
	private $cell_count;
	private $decrypted_data_array;

	private $rand_hex_colors_array;

	function __construct($id, $edit_mode = false)
	{
		FileLoader::Load('Resources.Library.Php.TableHandler');
		FileLoader::Load('Resources.Library.Php.RandomColor');
		FileLoader::Load('Resources.Library.Php.DashboardHandler');

		$this->table_id = $id;
		$this->table_edit_mode = $edit_mode;
		$this->decrypted_data_array = TableHandler::Load_Table($this->table_id);
		$this->Set_TableView_Properties();

		$this->rand_hex_colors_array = RandomColor::many($this->cell_count, array('luminosity' => 'dark', 'hue'=>'random'));
	}

	public function Save_TableView() {
		$table_savedata_array['properties'] = $this->decrypted_data_array['properties'];
		$table_savedata_array['table'] = array();
    	for ($y = 0; $y <= $this->table_height; $y++) { 
     		for ($x = 0; $x < $this->table_width; $x++) {
     			if (empty($_POST[$x.','.$y])) continue;
         		$table_savedata_array['table'][$x.','.$y] = $_POST[$x.','.$y];
       		}
     	}

     	if ($table_savedata_array !== $this->decrypted_data_array) {
     		TableHandler::Save_Table($this->table_id, $table_savedata_array);
     		var_dump('Saved!');
     	}
	}

	public function Generate_TableView() {
      $count = 1;
      $table  = '<table class="table bordered striped" align="center" style="background-color: #ffffff; color: #000;"><thead>';
      for ($y = 0; $y <= 8; $y++) { 
        $table .= '<tr><th>'.(($y == 0) ? '/' : $y).'</th>';
        for ($x = 0; $x < 5; $x++) { 
          $table .= $this->Generate_Cell($x, $y, $count); 
          $count++;     
        }
        $table .= '</tr>'.(($y == 0) ? '</thead><tbody>' : '');
      }
      $table .= '</tbody></table>';

      return $table;
    }

	private function Generate_Cell($x, $y, $count) {
      $content = (empty($this->decrypted_data_array[$x.','.$y])) ? '-' : $this->decrypted_data_array[$x.','.$y];
      $value = preg_replace('/-/', '', $content, 1);

      $cell  = '<th><span style="color: '.$this->rand_hex_colors_array[$count-1].';">';
      $cell .= ($this->table_edit_mode) ?  '<input class="timetable-th-input" name="'.$x.','.$y.'" type="text" placeholder="'.$content.'" value="'.$value.'" style="text-align: center;"/>' : $count.'_('.$x.'|'.$y.')_'.$content;
      $cell .= '</span></th>'; 
      return $cell;
    }

    private function Set_TableView_Properties() {
		$this->table_name = $this->decrypted_data_array['properties']['tablename'];
		$this->table_width = $this->decrypted_data_array['properties']['width'];
		$this->table_height = $this->decrypted_data_array['properties']['height'];
		$this->cell_count = $this->table_width * ($this->table_height + 1);
	}
}

?>