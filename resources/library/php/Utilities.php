<?php
	/**
	* IniParser
	**/
	class IniParser
	{
		public static function Parse($filepath, $can_be_empty = true) {
        	if (!file_exists($filepath)) die($filepath.' does not exist');
        	$array = parse_ini_file($filepath);

        	reset($array);
        	while (list($key, $value) = each($array)) {
            	$key = str_replace('-', '_', $key);
            	if ($can_be_empty) $value = (!empty($value)) ? $value : strtoupper($key);
            	define(strtoupper($key), $value);
        	}
		}
	}

	/**
	* FileLoader
	**/
	class FileLoader {
        private static $dirMap = array();

        /**
         * @param [type]
         * @param [type]
         */
        public static function Register($virtual, $physical) {
            self::$dirMap[$virtual] = $physical;
        }

        /**
         * @param [type]
         */
        public static function Load($file) {

            $pos = strrpos($file, '.');
            if ($pos === false) {
                die('Error: expected at least one dot.');
            }

            $path = substr($file, 0, $pos);
            $file = substr($file, $pos + 1);

            if (!isset(self::$dirMap[$path])) {
                die('Unknown virtual directory: '.$path);
            }

            require_once(self::$dirMap[$path].'/'.$file.'.php');
        }

        public static function Create_new_file($path, $string = '') {
            $array = explode('/', $path);
            $filepath = '';
        
            for ($i = 0; $i < count($array); $i++) {
                $filepath = $filepath.$array[$i].'/';
            
                if (!file_exists($filepath)){
                    $fp = fopen($path, 'w');
                    fwrite($fp, $string);
                    fclose($fp);
                }
            }
        }

        public static function Create_new_folder($path) {
            $array = explode('/', $path);
            $filepath = '';
            
            for ($i = 0; $i < count($array); $i++) {
                $filepath = $filepath.$array[$i].'/';
                
                if (!file_exists($filepath))
                    mkdir($filepath);
            }
        }

        public static function Scan_dir($path, $extension = null, $remove_extension = false) {
            if ($handle = opendir($path)) {
                while (false !== ($entry = readdir($handle))) {
                    $file_array = explode(".", $entry);
                    if ($entry == "." || $entry == "..") continue;

                    $file_extension_index = count($file_array) - 1;
                    if ($extension != null && $file_array[$file_extension_index] != $extension) continue;

                    if ($remove_extension)
                        unset($file_array[$file_extension_index]);

                    $array[] = implode('.', $file_array);
                }
                closedir($handle);
                var_dump($array);
            }
            return $array;
        }

        public static function deleteDir($dirPath) {
            if (! is_dir($dirPath)) throw new InvalidArgumentException("$dirPath must be a directory");
            if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') $dirPath .= '/';

            $files = glob($dirPath . '*', GLOB_MARK);
            foreach ($files as $file) {
                if (is_dir($file)) {
                    self::deleteDir($file);
                } else {
                    unlink($file);
                }
            }
            rmdir($dirPath);
        }
   	}

    /**
    * Array_Sort
    **/
    class Array_Sort
    {
        public static function Sort($array, $on, $order = SORT_ASC) {
            $new_array = array();
            $sortable_array = array();

            if (count($array) > 0) {
                foreach ($array as $key => $value) {
                    if (is_array($value)) {
                        foreach ($value as $key2 => $value2) {
                            if ($key2 == $on) {
                                $sortable_array[$key] = $value2;
                            }
                        }
                    } else {
                        $sortable_array[$key] = $value;
                    }
                }

                switch ($order) {
                    case SORT_ASC:
                        asort($sortable_array);
                        break;
                    case SORT_DESC:
                        arsort($sortable_array);
                        break;
                }

                foreach ($sortable_array as $key => $value) {
                    $new_array[$key] = $array[$key];
                }
            }
            return array_values($new_array);
        }
    }

    /**
    * NetworkUtilities
    */
    class NetworkUtilities
    {
        public static function Is_connected() {
            return @fsockopen("www.google.com", 80);
        }

        public static function Redirect_if_not_exists($var, $url) {
            if (!isset($var)) {
                header("Refresh:0; url=$url");
                exit;
            }
        }
    }

    /**
    * Git
    **/
    class Git {
        public static function GetGitCommitHash($major = '1', $minor = '0', $mode = 'dev') {
            $commit_hash = trim(exec('git log --pretty="%h" -n1 HEAD'));

            return sprintf('v%s.%s-%s.%s', $major, $minor, $mode, $commit_hash);
        }
    }

    /**
    * UUID class
    *
    * The following class generates VALID RFC 4122 COMPLIANT
    * Universally Unique IDentifiers (UUID) version 3, 4 and 5.
    *
    * UUIDs generated validates using OSSP UUID Tool, and output
    * for named-based UUIDs are exactly the same. This is a pure
    * PHP implementation.
    *
    * @author Andrew Moore
    * @link http://www.php.net/manual/en/function.uniqid.php#94959
    */
    class UUID
    {
        /**
         * Generate v3 UUID
         *
         * Version 3 UUIDs are named based. They require a namespace (another 
         * valid UUID) and a value (the name). Given the same namespace and 
         * name, the output is always the same.
         * 
         * @param   uuid    $namespace
         * @param   string  $name
         */
        public static function v3($namespace, $name)
        {
            if(!self::is_valid($namespace)) return false;
            // Get hexadecimal components of namespace
            $nhex = str_replace(array('-','{','}'), '', $namespace);
            // Binary Value
            $nstr = '';
            // Convert Namespace UUID to bits
            for($i = 0; $i < strlen($nhex); $i+=2) 
            {
                $nstr .= chr(hexdec($nhex[$i].$nhex[$i+1]));
            }
            // Calculate hash value
            $hash = md5($nstr . $name);
            return sprintf('%08s-%04s-%04x-%04x-%12s',
            // 32 bits for "time_low"
            substr($hash, 0, 8),
            // 16 bits for "time_mid"
            substr($hash, 8, 4),
            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 3
            (hexdec(substr($hash, 12, 4)) & 0x0fff) | 0x3000,
            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            (hexdec(substr($hash, 16, 4)) & 0x3fff) | 0x8000,
            // 48 bits for "node"
            substr($hash, 20, 12)
            );
        }
        
        /**
        * 
        * Generate v4 UUID
        * 
        * Version 4 UUIDs are pseudo-random.
        */
        public static function v4() 
        {
            return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            // 32 bits for "time_low"
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            // 16 bits for "time_mid"
            mt_rand(0, 0xffff),
            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 4
            mt_rand(0, 0x0fff) | 0x4000,
            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            mt_rand(0, 0x3fff) | 0x8000,
            // 48 bits for "node"
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
            );
        }
    
        /**
        * Generate v5 UUID
        * 
        * Version 5 UUIDs are named based. They require a namespace (another 
        * valid UUID) and a value (the name). Given the same namespace and 
        * name, the output is always the same.
        * 
        * @param   uuid    $namespace
        * @param   string  $name
        */
        public static function v5($namespace, $name) 
        {
            if(!self::is_valid($namespace)) return false;
            // Get hexadecimal components of namespace
            $nhex = str_replace(array('-','{','}'), '', $namespace);
            // Binary Value
            $nstr = '';
            // Convert Namespace UUID to bits
            for($i = 0; $i < strlen($nhex); $i+=2) 
            {
                $nstr .= chr(hexdec($nhex[$i].$nhex[$i+1]));
            }
            // Calculate hash value
            $hash = sha1($nstr . $name);
            return sprintf('%08s-%04s-%04x-%04x-%12s',
            // 32 bits for "time_low"
            substr($hash, 0, 8),
            // 16 bits for "time_mid"
            substr($hash, 8, 4),
            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 5
            (hexdec(substr($hash, 12, 4)) & 0x0fff) | 0x5000,
            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            (hexdec(substr($hash, 16, 4)) & 0x3fff) | 0x8000,
            // 48 bits for "node"
            substr($hash, 20, 12)
            );
        }
        public static function is_valid($uuid) {
            return preg_match('/^\{?[0-9a-f]{8}\-?[0-9a-f]{4}\-?[0-9a-f]{4}\-?'.'[0-9a-f]{4}\-?[0-9a-f]{12}\}?$/i', $uuid) === 1;
        }
    }
?>