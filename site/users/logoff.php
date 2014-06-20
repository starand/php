<?
	include_once "../files/common.php";
	include_once "../users/users.php";
	include_once "../forums/forums.php";
	$user = CheckUser();
	if($user) 
	{
		UpdateIp($user['uId'],$REMOTE_ADDR); 
		AddLogMsg($user['uId'], "", 2);
		//AddChatMsg($user['uId'],"<b style=\"color:gray;\">[ вийшов з сайту ]</b>");
	}
	
	/* Cookie expires when browser closes */
	setcookie('username', $_POST['nick'], false, '/files');
	setcookie('password', md5(md5($_POST['pswd']).$_POST['nick']), false, '/files');
	
	
	$_SESSION = array();
	include_once "enter.php";
?>
