<?
	include_once "common.php";
	include_once "../users/users.php"; 
	include_once "../forums/forums.php";
	
	if(!CheckUser() && isset($_COOKIE['username']) && isset($_COOKIE['password'])) 
	{
		$usr = GetUserByNick($_COOKIE['username']);
		if($usr && $_COOKIE['password'] == md5($usr['uPswd'].strtolower($usr['uNick'])))
		{
			$_SESSION["n_user"] = $usr;
			AddLogMsg($usr['uId'], $usr['uPswd'], 6);
			$user = CheckUser();
			AddJarvisMessage( "{$usr['uNick']} autologin into SafetyLab" );
		}
	}

	$user = CheckUser();
	if(!$user) EchoErrorMsg("","../users/enter.php");	

	$nl = GetNewMsgs();
	if($nl) 
	{
		if(is_array($_SESSION['n_new_msgs'])) $_SESSION['n_new_msgs'] = $nl + $_SESSION['n_new_msgs'];
		else $_SESSION['n_new_msgs'] = $nl;
	}	
	UpdateLastTime($user['uId']);
?><HEAD><LINK href='<? echo style()."main.css"; ?>' rel=stylesheet type=text/css>
<meta http-equiv='Content-Type' content='text/html; charset=windows-1251'></HEAD><center>
<script language=javascript src='../files/main.js'></script>
<div style='margin:0px; padding:0px; position: relative;width:1262;'>
<?
	if(isset($_GET['script'])) $_SESSION['script'] = $_GET['script'];
	elseif(!isset($_SESSION['script'])) $_SESSION['script'] = "main";

	$page = GetPage($_SESSION['script']); 
	if(!$page)
	{
		$_SESSION['script'] = "main";
		die("Error! Page not found!");
	}
	
	$_SESSION['script_path'] = $page['pPath'];
	$_SESSION['pType'] = $page['pType'];
?>
<table cellSpacing=0 cellPadding=0 border=0 style='width:100%;'>
<tr><td><div class='chatwnd' style='visibility:hidden;' id='video'></td>
<td class='main' style='' >
<?
	include_once "toppanel.php";
	include_once "menu.php";	
?>
<!-- START MAIN CODE-->
<?
	if(isset($_POST['msg']) || isset($_GET['msg'])) 
	{
		if(isset($_POST['msg'])) $msg = $_POST['msg'];
		if(isset($_GET['msg'])) $msg = $_GET['msg'];
		echo "<div class='warning'>$msg</div>";
		$_SESSION['script'] = "forums";
		$_SESSION['script_path'] = "content.php";
	}
	
	echo "<hr>";

	include_once $_SESSION['script_path'];	
?>
<!-- END MAIN CODE-->
</td></tr>
</table>
</div>
