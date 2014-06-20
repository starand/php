<?
function CorrectText( &$text )
{
	$text = str_replace("<","&lt;",$text);
	$text = str_replace(">","&gt;",$text);
	//$text = str_replace('"',"&quot;",$text);
	//$text = preg_replace("'(\r\n)'si","<br>\\1", $text);
}
function AddCPData( $uid, $text )
{
	CorrectText( $text );
	$sql = "INSERT INTO copypaste VALUES( NULL, $uid, now(), '".addslashes($text)."')";
	return uquery($sql);
}

function GetLastCPDatas( $uid, $limit = 20 )
{
	$sql = "SELECT * FROM copypaste WHERE cpUid=$uid LIMIT $limit";
	$res = uquery($sql);
	for($result = array(); $row = mysql_fetch_array($res); $result[]=$row);
	if( $res && mysql_num_rows($res) ) return $result;
	return 0;
}

function DelCPData($uid, $id)
{
	$sql = "DELETE FROM copypaste WHERE cpUid=$uid AND cpId=$id";
	return uquery($sql);
}
?>