<?
	include_once "../files/common.php";
	include_once "forums.php";
	include_once "../users/users.php";
	if(!($user=CheckUser())) EchoErrorMsg("","../users/enter.php");
	if(!isset($_GET['link'])) die("link not isset");
	
	$pmsg = $mid = (int)$link; if(!$link) die("link == 0");
	$msg = GetMsg($mid);
	if($msg['mPmsg'] != 0) 
	{
		$msg = GetMsg($msg['mPmsg']);
		$pmsg = $msg['mId'];
	}
	$theme = $msg['mTheme'] === "" ? $mid : $msg['mTheme'];
	if(strlen($theme) > 17) $theme = substr($theme, 0, 17)."..";
	AddFastLink($theme, $pmsg."#id".$mid, $user['uId']);
	include_once "fastlinks.php";
?>