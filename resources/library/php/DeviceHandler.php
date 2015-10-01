<?php
	/**
	* Device Handler
	**/
	class DeviceHandler
	{
		private $host;

		function __construct()
		{
			$this->host = $_SERVER['HTTP_HOST'];
			if ($this->Check_if_device_is_mobile())
				header("Location: http://".$this->host."/stundenplan/mobile/index.php");
		}

		public function Check_if_device_is_mobile()
		{
			return (bool)preg_match('#\b(ip(hone|od)|android\b.+\bmobile|opera m(ob|in)i|windows (phone|ce)|blackberry'.
				'|s(ymbian|eries60|amsung)|p(alm|rofile/midp|laystation portable)|nokia|fennec|htc[\-_]'.
                '|up\.browser|[1-4][0-9]{2}x[1-4][0-9]{2})\b#i', $_SERVER['HTTP_USER_AGENT'] );
		}

		public function Head_to_mobile_site($site)
		{
			header("Location: http://".$this->host."/stundenplan/mobile/".$site);
		}

		public function Head_to_normal_site($site)
		{
			header("Location: http://".$this->host."/stundenplan/".$site);
		}

		public function Head_to_site($target)
		{
			$url = ($this->Check_if_device_is_mobile) ? 'http://'.$this->host.'/stundenplan/mobile/'.$target : 'http://'.$this->host.'/stundenplan/'.$target;
			header('Location: '.$url);
		}
	}

?>