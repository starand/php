<?
function AddKarma($uid, $mark, $fid, $mid)
{
	$sql = "INSERT INTO karma VALUES(NULL, $uid, $mark, $fid, $mid)";
	return uquery($sql);
}

## return msg karma by id and set user
function GetMsgKarmaByUid($fid, $mid)
{
	$sql = "SELECT * FROM karma WHERE krmFid=$fid AND krmMid=$mid";
	$res = uquery($sql);
	if($res && mysql_num_rows($res)) return mysql_fetch_array($res);
	else return 0;
}

?>