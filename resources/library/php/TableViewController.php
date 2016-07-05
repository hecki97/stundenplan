<?php
use Utilities\Dir;
use Colors\RandomColor;

/**
* TableViewController
*/
class TableViewController
{
	public $table_name;
	public $table_width;
	public $table_height;

	private $table_id;
	private $view;
	private $cell_count;
	private $decrypted_data_array;

	private $subjects_array;

	function __construct($id, $view = 'table')
	{
		Dir::include_file('Resources.Library.Php.TableHandler');
		Dir::include_file('Resources.Library.Php.RandomColor');
		Dir::include_file('Resources.Library.Php.DashboardHandler');

		$this->table_id = $id;
		$this->view = $view;
		$this->decrypted_data_array = TableHandler::Load_Table($this->table_id);
		$this->Set_TableView_Properties();

		$this->subjects_array = (!empty($this->decrypted_data_array['subject_color'])) ? $this->decrypted_data_array['subject_color'] : array('-' => '#393939');
	}

  //TODO: Finish SaveSystem
	public function Save_TableView() {
    $table_savedata_array['properties'] = array('tablename' => 'Test'/*$_POST['tablename']*/, 'timestamp' => time(), 'width' => 5/*$_POST['width']*/, 'height' => 8/*$_POST['height']*/, 'empty' => true);
		$table_savedata_array['table'] = array();
    $table_savedata_array['subject_color'] = array('-' => '#393939');

    	for ($y = 0; $y <= $this->table_height; $y++) { 
     		for ($x = 0; $x < $this->table_width; $x++) {
     			  if (empty($_POST[$x.','.$y])) continue;
            $subject = $_POST[$x.','.$y];
         		$table_savedata_array['table'][$x.','.$y] = $subject;
            
            //TODO: Persistent Color Saving
            if (!array_key_exists($subject, $table_savedata_array['subject_color']))
              $table_savedata_array['subject_color'][$subject] = (array_key_exists($subject, $this->decrypted_data_array['table'])) ? $this->decrypted_data_array['table'][$subject] : RandomColor::one(array('luminosity' => 'dark', 'hue'=>'random'));
       		}
     	}
      if (!empty($table_savedata_array['table'])) $table_savedata_array['properties']['empty'] = false;

     	if ($table_savedata_array !== $this->decrypted_data_array) TableHandler::Save_Table($this->table_id, $table_savedata_array);
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
    $content = (empty($this->decrypted_data_array['table'][$x.','.$y])) ? '-' : $this->decrypted_data_array['table'][$x.','.$y];
    $value = preg_replace('/-/', '', $content, 1);

    $cell  = '<th><span style="color: '.$this->subjects_array[$content].';">';
    $cell .= ($this->view == 'edit') ?  '<input class="timetable-th-input" name="'.$x.','.$y.'" type="text" placeholder="'.$content.'" value="'.$value.'" style="text-align: center;"/>' : $content;
    $cell .= '</span></th>';

    return $cell;
  }

  public function Generate_ColorTableView() {
    if (!empty($this->decrypted_data_array['table']) > 1) {
      foreach ($this->decrypted_data_array['table'] as $subject) {
        if (!array_key_exists($subject, $this->subjects_array)) $this->subjects_array[$subject] = RandomColor::one(array('luminosity' => 'dark', 'hue'=>'random'));
      }
    }
    $array = array(array_keys($this->subjects_array), array_values($this->subjects_array));
    $table  = '<table id="js-container" class="table bordered striped" align="center" style="background-color: #ffffff; color: #000;">';
    $table .= '<thead><th style="width: 15px;">#</th><th>Subject</th><th>Hexcolor</th><th style="width: 15px;">#</th><th>Subject</th><th>Hexcolor</th></thead><tbody">';
    
    $count = (count($array[0]) % 2 == 0) ? count($array[0]) / 2 : (count($array[0]) + 1) / 2;
    $j = 0;
    for ($i = 0; $i < $count; $i++) { 
      $table .= '<tr>';
      $table .= self::Generate_Item($array, $i);
      if (isset($array[0][$count + $j])) {
        $table .= self::Generate_Item($array, ($count + $j));
        $j++;
      }
      $table .= '</tr>';
    }
    $table .= '</tbody></table>';

    return $table;
  }

  private static function Generate_Item($array, $count) {
    $item = '<th>'.($count + 1).'</th>';
    $item .= '<th>'.$array[0][$count].'</th>';
    $item .= '<th id="'.$count.'"><div class="circle" style="background: '.$array[1][$count].';"><span class="info">HEX <span class="color-string" title="Click to edit!">'.$array[1][$count].'</span><!--<button type="button" onClick="SwitchColorString(this);" class="button mini-button disabled" style="margin: 0 0 0 10px;"><span class="mif-cross fg-red"></span></button><button type="button" onClick="SwitchColorString(this);" class="button mini-button disabled" style="margin: 0;"><span class="mif-checkmark fg-green"></span></button>--></div><div class="info" style="display: inline; float: right; position: relative;"><button type="button" onClick="GenerateRandomColor(this);" class="button mini-button" style="margin: 0 0 0 10px;"><span class="mif-dice"></span></button><button type="button" onClick="SwitchColorString(this);" class="button mini-button disabled" style="margin: 0 0 0 10px;">HEX</button><button type="button" onClick="SwitchColorString(this);" class="button mini-button" style="margin: 0;">RGB</button></div></th>';

    return $item;
  }

  private function Set_TableView_Properties() {
		$this->table_name = $this->decrypted_data_array['properties']['tablename'];
		$this->table_width = $this->decrypted_data_array['properties']['width'];
		$this->table_height = $this->decrypted_data_array['properties']['height'];
		$this->cell_count = $this->table_width * ($this->table_height + 1);
	}
}

?>