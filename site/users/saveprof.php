<?
	include_once "../files/common.php";
	include_once "../forums/forums.php";
	include_once "users.php";
	$user = CheckUser();
	if(!$user) EchoErrorMsg("Ви не аутентифікований користувач","../users/enter.php");


	if(!isset($_POST['pswd']) || !isset($_POST['mail']) 
		|| !isset($_POST['style']) || !isset($_POST['icq']) || !isset($_POST['signature']) ) EchoErrorMsg("Немає даних");
	$style = (int)$_POST['style'];
	$pswd = $_POST['pswd'];
	$mail = DelXSS($_POST['mail']);
	$icq = DelXSS($_POST['icq']);
	$signature = DelXSS($_POST['signature']);
	if($user['uStyle']!=$style) {
		SetStyle($user['uId'],$style); 
		$style = GetStyle($style);
		$_SESSION["n_style"] = $style['stPrefix'];
	}
	if($user['uMail']!==$mail) SetMail($user['uId'],$mail);
	if($user['uICQ']!==$icq) SetICQ($user['uId'],$icq);
	if($pswd!=="") SetPassword($user['uId'],$pswd);
	if($user['signature']!==$signature) SetSignature($user['uId'],$signature);
	
	$_SESSION['n_user'] = GetUser($user['uId']);
	AddLogMsg($user['uId'], "", 108);
	
	EchoErrorMsg("Зміни збережено");
?>
