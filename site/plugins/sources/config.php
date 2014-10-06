<?
	$base_dir = realpath("e:\\sources");
	
	function files_list($dir, &$files, &$dirs)
	{
		if ($handle = opendir($dir))
		{
			$files = array(); $dirs = array();
			while (false !== ($entry = readdir($handle)))
			{
				if ($entry != ".")
				{
					$full_name = path_join($dir, $entry);
					
					if (is_dir($full_name))
					{
						$dirs[] = $full_name;
					}
					else
					{
						$files[] = $full_name;
					}
				}
			}

			closedir($handle);
			return true;
		}
		else return false;
	}
	
	function prepare_path($dir, &$short_name)
	{
		global $base_dir;
		$len = strlen($base_dir);

		if (substr($dir, 0, $len) === $base_dir)
		{
			$short_name = basename($dir);
			return substr($dir, $len + 1);
		}
		
		return false;
	}
	
	function prepare_dir_link($dir)
	{
		$dir = prepare_path($dir, $short);
		if ($dir == false) return false;
		
		return "<a href='?dir=$dir' class='dir'>$short</a> &nbsp; ";
	}
	
	function prepare_file_link($file)
	{
		$file = prepare_path($file, $short);
		if ($file == false) return false;
		
		return "<a href='?file=$file&dir=".dirname($file)."' class='file'>$short</a> &nbsp; ";
	}
	
	function correct_slashes($path)
	{
		$res = str_replace("\\\\", "\\", $path);
		$res = str_replace("//", "\\", $res);
		return $res;
	}
	
	function path_join($p1, $p2)
	{
		if (substr($p1, -1) == '\\' || substr($p1, -1) == '/') $p1 = rtrim($p1, "\\/");
		if ($p2[0] == '/' || $p2[0] == '\\') $p2 = ltrim($p2, '\\/');
		$path = correct_slashes("$p1\\$p2");
		return $path;
	}
	
?>