<?
	function AddFile($name, $desc, $cont)
	{
		global $user;
		$md5 = md5($cont);
		$sql = "INSERT INTO files VALUES(NULL, '$name', '$cont', '$md5', '$desc', {$user['uId']})";
		return uquery($sql);
	}
	
	function FileExists($fname)
	{
		$sql = "SELECT 1 FROM files WHERE fileName='$fname'";
		$res = uquery($sql);
		if($res && mysql_num_rows($res)) return 1;
		return 0;
	}
	
	function GetFile($fid)
	{
		$sql = "SELECT fileId, fileName, fileMd5, fileDesc, fileUid, LENGTH(fileCont)as fileSize FROM files WHERE fileId=$fid";
		$res = uquery($sql);
		if($res && mysql_num_rows($res)) return mysql_fetch_array($res);
		return 0;
	}
	
	function GetFileCont($fid)
	{
		$sql = "SELECT fileCont FROM files WHERE fileId=$fid";
		$res = uquery($sql);
		if($res && mysql_num_rows($res)) return mysql_result($res, 0, 0);
		return 0;
	}
	
	function GetFiles()
	{
		$sql = "SELECT fileId, fileName, fileMd5, fileDesc, fileUid, LENGTH(fileCont)as fileSize FROM files";
		$res = uquery($sql); $result = array();
		for(; $row = mysql_fetch_array($res); $result[] = $row);
		if($res && mysql_num_rows($res)) return $result;
		return 0;
	}

?>