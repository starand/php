<?
	function AddFile( $name, $desc, $cont, $detId, $type )
	{
		global $user;
		$md5 = md5($cont);
		$sql = "INSERT INTO radio.files VALUES( NULL, '$name', '$cont', '$md5', '$desc', $detId, '$type' )";
		return uquery($sql);
	}
	
	function FileExists( $fname )
	{
		$sql = "SELECT 1 FROM radio.files WHERE fileName='$fname'";
		$res = uquery($sql);
		if($res && mysql_num_rows($res)) return 1;
		return 0;
	}
	
	function GetFile( $fid )
	{
		$sql = "SELECT fileId, fileName, fileMd5, fileDesc, LENGTH(fileCont) as fileSize FROM radio.files WHERE fileId=$fid";
		$res = uquery($sql);
		if($res && mysql_num_rows($res)) return mysql_fetch_array($res);
		return 0;
	}
	
	function GetFileCont( $fid )
	{
		$sql = "SELECT fileCont FROM radio.files WHERE fileId=$fid";
		$res = uquery($sql);
		if($res && mysql_num_rows($res)) return mysql_result($res, 0, 0);
		return 0;
	}
	
	function GetFiles( $detId = 'fileItemId')
	{
		$sql = "SELECT fileId, fileName, fileMd5, fileDesc, LENGTH(fileCont)as fileSize FROM radio.files WHERE fileItemId=$detId";
		$res = uquery($sql); $result = array();
		for(; $row = mysql_fetch_array($res); $result[] = $row);
		if($res && mysql_num_rows($res)) return $result;
		return 0;
	}

?>