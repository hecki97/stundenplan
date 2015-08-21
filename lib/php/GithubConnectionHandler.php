<?php
	class GithubConnectionHandler
	{
		/* static settings */
		private $repo;
		private $owner;
		private $cache_path; //= dirname(__FILE__).'/../../repo-cache/';
		private $cache_file; //= $repo.'-github.txt';
		public $github_json; //= get_repo_json($cache_path.$cache_file,$repo);

		public function __construct()
		{
			$this->repo = 'stundenplan';
			$this->owner = 'hecki97';
			$this->cache_path = dirname(__FILE__).'/../../res/cache/';
			$this->cache_file = 'version-cache.txt';
			$this->github_json = $this->get_repo_json($this->cache_path.$this->cache_file,$this->repo);
			//var_dump($this->github_json);
		}

		/* gets url */
		function get_content_from_github($url) {
			
		    $curl = curl_init();
    		curl_setopt_array($curl, array(
      			CURLOPT_RETURNTRANSFER => 1,
      			CURLOPT_USERAGENT => $this->repo,
      			CURLOPT_URL => 'https://api.github.com/repos/hecki97/repos'
      			//CURLOPT_URL => 'https://api.github.com/repos/' . $this->owner . '/' . $this->repo
    		));
    		$response = curl_exec($curl);
    		curl_close($curl);
    		if ($response) {
      			$response_array = json_decode($response);
      			return base64_decode($response_array->content);
    		} else {
    			print_r('<p> There was an error with the API call. </p>');
    			return null;
    		}
		}

		/* gets the contents of a file if it exists, otherwise grabs and caches */
		function get_repo_json($file, $repo) {
			//vars
			$current_time = time();
			$expire_time = 24 * 60 * 60;
			$file_time = filemtime($file);

			//decisions, decisions
			if(!file_exists($file) && ($current_time - $expire_time < $file_time)) {
				//echo 'returning from cached file';
				return json_decode(file_get_contents($file));
			}
			else
			{
				$data = $this->get_content_from_github("https://api.github.com/repos/hecki97/stundenplan");
				var_dump($data);

				$json = array();
				$json = json_decode($data, true);
				//$json = json_decode($this->get_content_from_github('https://api.github.com/repos/hecki97/stundenplan'),true);
				var_dump($json);
				//$json['commit'] = json_decode(get_content_from_github('http://github.com/api/v2/json/commits/list/hecki97/'.$repo.'/master'),true);
				//$json['readme'] = json_decode(get_content_from_github('http://github.com/api/v2/json/blob/show/darkwing/'.$repo.'/'.$json['commit']['commits'][0]['parents'][0]['id'].'/Docs/'.$plugin.'.md'),true);
				//$json['js'] = json_decode(get_content_from_github('http://github.com/api/v2/json/blob/show/darkwing/'.$repo.'/'.$json['commit']['commits'][0]['parents'][0]['id'].'/Source/'.$plugin.'.js'),true);
				file_put_contents($file, json_encode($json));
				return $json;
			}
		}
	}
?>