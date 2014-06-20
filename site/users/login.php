<?
	include_once "../files/common.php";
	include_once "../forums/forums.php";
	include_once "users.php";

	if(CheckUser()) EchoErrorMsg();
	
	// cookies
	if(isset($_POST['rememberme']) && isset($_POST['nick']) && isset($_POST['pswd'])) 
	{
		/* Set cookie to last 1 year */
		setcookie('username', $_POST['nick'], time()+60*60*24*365, '/files');
		setcookie('password', md5(md5($_POST['pswd']).strtolower($_POST['nick'])), time()+60*60*24*365, '/files');
	} 
	else 
	{
		/* Cookie expires when browser closes */
		setcookie('username', $_POST['nick'], false, '/files');
		setcookie('password', md5(md5($_POST['pswd']).$_POST['nick']), false, '/files');
	}
	
	
	if(!isset($_POST['nick']) || !isset($_POST['pswd'])) EchoErrorMsg("Access Denied","enter.php");
	$nick = DelXSS($_POST['nick']);	$pswd = $_POST['pswd'];
	if($nick==="" || $pswd==="") EchoErrorMsg("Access Denied","enter.php");
	$user = GetUserByNick($nick);
	if(!$user) EchoErrorMsg("Access Denied","enter.php");
	if($user['uPswd']!==md5($pswd)) 
	{
		AddLogMsg($user['uId'], "$pswd",4);
		EchoErrorMsg("Access Denied","enter.php");
	}
	$_SESSION["n_user"] = $user;
	$style = GetStyle($user['uStyle']);
	$_SESSION["n_style"] = $style['stPrefix'];
	$_SESSION['n_new_msgs'] = GetNewMsgs($user['uId']);
	UpdateIp($user['uId'], $REMOTE_ADDR);
	AddLogMsg($user['uId'], "", 1);
	AddJarvisMessage( "{$user['uNick']} logined into SafetyLab" );
	//AddChatMsg($user['uId'],"<b style=\"color:gray;\">[ увійшов на сайт ]</b>");
	EchoErrorMsg();
?>