<?
	include_once "../files/common.php";
	include_once "../users/users.php";
	include_once "forums.php";
	
function ShowResult($text)
{
	echo "<tr style='background:#333333'><td colspan='2' class='deleted'>$text</td><tr>";
}
	
	if(!($user=CheckUser()) || !isset($_GET['dId'])) EchoErrorMsg("","../users/enter.php");
	$dId = (int)$_GET['dId'];
	$msg = GetMsg($dId);	if(!$dId || !$msg) die();
	$sm = GetSubMsgs($msg['mId']);
	if($msg['mPmsg']>0) $msg = GetMsg($msg['mPmsg']);
	if(!$sm) DelMsg($dId, $user['uId']);
	AddLogMsg($user['uId'], addslashes($msg['mTheme']),105);
	if($msg['mId'] != $dId)	
		ShowResult("”сп≥шно видалено!");
	else if($sm)
		ShowResult("—першу видал≥ть в≥дов≥д≥!");
	else
		echo "<script>parent.frames.main.document.location.href='../files/main.php?script=showforum&fid={$msg['mFid']}';</script>";
?>
