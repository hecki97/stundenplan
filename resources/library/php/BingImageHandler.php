<?php
	/**
	* BingImageHandler
	**/
	class BingImageHandler
	{
		public $dirname = 'cache';
		public $filename = 'BingWallpaper.jpg';

		private $file_full_path;
		private $dir_path;

		function __construct()
		{
			$this->dir_path = dirname(__FILE__).'/../../../img/'.$this->dirname;
			$this->file_full_path = $this->dir_path.'/'.$this->filename;
			// $this->filename = 'BingWallpaper.jpg';

			$this->Create_folder_if_not_exists();
			$this->Get_Image_from_Bing();
		}

		function Create_folder_if_not_exists() {
			if (!is_dir($this->dir_path) && !file_exists($this->dir_path))
				mkdir($this->dir_path);
		}

		function Get_Image_from_Bing()
		{
			$current_time = time();
			$expire_time = 24 * 60 * 60;
			$file_time = file_exists($this->file_full_path) ? filemtime($this->file_full_path) : time();

			if (!file_exists($this->file_full_path) || ($current_time - $expire_time > $file_time))
				copy('https://www.bing.com/ImageResolution.aspx?w=1920&h=1080', $this->file_full_path);

			// if ((time() - $last_update) >= 86400 && (date('G') < 7))
			// {
				// copy('https://www.bing.com/ImageResolution.aspx?w=1920&h=1080', $file_full_path);
				// $last_update = time();
			// }
		}
	}
?>