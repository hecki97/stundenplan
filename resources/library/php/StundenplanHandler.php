<?php
	/**
	* StundenplanHandler
	**/
	class StundenplanHandler
	{
		public $decrypted_file;
		public $key;
		private $id;

		public function __construct($id) {
			require_once('CryptHandler.php');
			$cryptHandler = new CryptHandler();
			require_once('DatabaseHandler.php');
			$databaseHandler = new DatabaseHandler();

			$file = file_get_contents('resources/data/'.$_SESSION['username'].'.dat');

			$cryptHandler->setKey($databaseHandler->Get_Encryption_Key_from_database($_SESSION['username']));
			$this->decrypted_file = $cryptHandler->decrypt($file);

  			for ($this->key = 0; $this->key < count($this->decrypted_file); $this->key++) { 
      			$this->id = $this->decrypted_file[$this->key]['id'];
      			if ($this->id == $id) break;
  			}
		}

		public function Load_Timetable_View() {
			$table  = '<table class="table bordered striped" align="center" style="background-color: #ffffff; color: #000;">';
  			$table .= '<thead><tr><th>/</th><th>Montag</th><th>Dienstag</th><th>Mittwoch</th><th>Donnerstag</th><th>Freitag</th><tr></thead>';
  			$table .= '<tbody>';
  			for ($y = 1; $y <= $this->decrypted_file[$this->key]['height']; $y++) { 
   				$table .= '<tr><th>'.$y.'</th>';
   				for ($x = 1; $x <= $this->decrypted_file[$this->key]['width']; $x++) {
   					$placeholder = (empty($this->decrypted_file[$this->key]['savedata']['x'.$x.'y'.$y])) ? '-' : $this->decrypted_file[$this->key]['savedata']['x'.$x.'y'.$y];
   					$value = (empty($this->decrypted_file[$this->key]['savedata']['x'.$x.'y'.$y])) ? '' : $this->decrypted_file[$this->key]['savedata']['x'.$x.'y'.$y];
   					$table .= '<th>'.$placeholder.'</th>';
   				}
    			$table .= '</tr>';
  			}
  			$table .= '</tbody></table>';

  			return $table;
		}

		public function Load_Timetable_Edit() {
			$table  = '<table class="table bordered striped" align="center" style="background-color: #ffffff; color: #000;">';
  			$table .= '<thead><tr><th>/</th><th>Montag</th><th>Dienstag</th><th>Mittwoch</th><th>Donnerstag</th><th>Freitag</th><tr></thead>';
  			$table .= '<tbody>';
  			for ($y = 1; $y <= $this->decrypted_file[$this->key]['height']; $y++) { 
    			$table .= '<tr><th>'.$y.'</th>';
    			for ($x = 1; $x <= $this->decrypted_file[$this->key]['width']; $x++) {
      				$placeholder = (empty($this->decrypted_file[$this->key]['savedata']['x'.$x.'y'.$y])) ? '-' : $this->decrypted_file[$this->key]['savedata']['x'.$x.'y'.$y];
      				$value = (empty($this->decrypted_file[$this->key]['savedata']['x'.$x.'y'.$y])) ? '' : $this->decrypted_file[$this->key]['savedata']['x'.$x.'y'.$y];
      				$table .= '<th><input class="timetable-th-input" name="x'.$x.'y'.$y.'" type="text" placeholder="'.$placeholder.'" value="'.$value.'" style="text-align: center;"/></th>';
    			}
    			$table .= '</tr>';
  			}
  			$table .= '</tbody></table>';

  			return $table;
		}

		public function Save_Timetable() {
			$this->decrypted_file[$this->key]['name'] = $_POST['tablename'];
      		$this->decrypted_file[$this->key]['timestamp'] = time();
      		$this->decrypted_file[$this->key]['width'] = $_POST['width'];
      		$this->decrypted_file[$this->key]['height'] = $_POST['height'];
      		if (array_key_exists('savedata', $this->decrypted_file[$this->key])) unset($this->decrypted_file[$this->key]['savedata']);

      		$savedata_array = array();
      		for ($y = 1; $y <= $this->decrypted_file[$this->key]['height'] ; $y++) { 
        		for ($x = 1; $x <= $this->decrypted_file[$this->key]['width'] ; $x++) {
          			if (empty($_POST['x'.$x.'y'.$y])) continue;
            		$savedata_array['x'.$x.'y'.$y] = $_POST['x'.$x.'y'.$y];
        		}
      		}

      		$this->decrypted_file[$this->key]['savedata'] = $savedata_array;
      		$fp = fopen('resources/data/'.$this->filename.'.json', 'w');

      		$encrypted_file = $cryptHandler->Encrypt($databaseHandler->Get_Encryption_Key_from_database, $this->decrypted_file);
      		var_dump($encrypted_file);

      		fwrite($fp, $encrypted_file);
      		fclose($fp);
		}
	}
?>