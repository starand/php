<?
	include_once "../files/common.php";
	include_once "../users/users.php";
	include_once "../forums/karma.php";
	include_once "../forums/forums.php";
	
	if(!($user=CheckUser())) die();
	
//	if(!isset($_GET['mid']) || !isset($_GET['mark'])) die();
	if(!isset($_GET['mid'])) die();
	$mid = (int)$_GET['mid']; $msg = GetMsg($mid); if(!$msg) die();
	//$mark = (int)$_GET['mark']; if($mark > 3 || $mark < 1) die();
	$mark = 1;
	
	if($user['uId'] == $msg['mUid'])
		die("<script>Ви не можете оцінювати самі себе!</script>");
	
	AddKarma($msg['mUid'], $mark, $user['uId'], $msg['mId']);
?>
<script>alert("Ви оцінили повідомлення!");</script>