<?
	include_once "../files/common.php";
	include_once "users.php";  
	include_once "../forums/forums.php";
	include_once "../forums/highlight.php";
	
	$user['uLevel'] = 0;

?><HEAD><LINK href='<? echo style()."main.css"; ?>' rel=stylesheet type=text/css>
<meta http-equiv='Content-Type' content='text/html; charset=windows-1251'></HEAD>

<?
	if(isset($_POST['nick']) && isset($_POST['email']) && isset($_POST['icq']) && isset($_POST['activity']) && isset($_POST['why']))
	{
		if($_POST['nick'] === "" || $_POST['email'] === "" || $_POST['icq'] === "" || $_POST['activity'] === "" || $_POST['why'] === "")
		{
			EchoErrorMsg("Поля не повинні бути пустими!","../users/invite.php");
		}
		
		$nick = DelXSS($_POST['nick']);
		$email = DelXSS($_POST['email']);
		$icq = DelXSS($_POST['icq']);
		$activity = DelXSS($_POST['activity']);
		$why = DelXSS($_POST['why']);
		
		$msg = '[table][tr][td]Login:[/td][td][b][m]'.$nick.'[/m][/b][/td][/tr]';
		$msg.= '[tr][td]Email:[/td][td][b][y]'.$email.'[/y][/b][/td][/tr]';
		$msg.= '[tr][td]ICQ : [/td][td][b][o]'.$icq.'[/o][/b][/td][/tr]';
		$msg.= '[tr][td]Activity: [/td][td]'.$activity.'[/td][/tr]';
		$msg.= '[tr][td]Why ? [/td][td]'.$why.'[/td][/tr][/table]';
		$premsg = PrepareMsg($msg);
		AddMsg(0, 96, 0, $nick, $premsg, $REMOTE_ADDR, $msg, 10);
	
		$msg = "Заявка прийнята і буде розглянута на протязі декількох днів";
		include_once "enter.php";
		die();
	}
?>

<table height="100%" width="100%" style="vertical-align:middle;text-align:center;background-image:url(../img/enter.jpg); background-position:center; background-repeat: no-repeat">
<tr><td style='vertical-align:middle;text-align:center;'>
<center>
<?
	$msg = "";
	if(isset($_POST['msg'])) $msg = $_POST['msg'];
	else if(isset($_GET['msg'])) $msg = $_GET['msg'];
	echo "<div class='warning'>$msg</div>";
?>
<br><br>
<h1>Invite system</h1>
<div class='frmframe' style='width:400px;'><table class='frmlist' cellspacing='0'>
<form action='' method=post>
<tr style='background:#282828;'><td class='padding'>Nick: </td></tr>
<tr style='background:#282828;'><td class='padding'><input type=text name='nick' style='width:380px;'></td></tr>
<tr style='background:#282828;'><td class='padding'>Em@il: </td></tr>
<tr style='background:#282828;'><td class='padding'><input type=text name='email' style='width:380px;'></td></tr>
<tr style='background:#282828;'><td class='padding'>ICQ/Skype/Jabber: </td></tr>
<tr style='background:#282828;'><td class='padding'><input type=text name='icq' style='width:380px;'></td></tr>
<tr style='background:#282828;'><td class='padding'>Рід занять/Профілі: </td></tr>
<tr style='background:#282828;'><td class='padding'><textarea name=activity style='width:380px;height:100px;background:black;color:yellow;'></textarea></td></tr>
<tr style='background:#282828;'><td class='padding'>Чому я хочу на сайт: </td></tr>
<tr style='background:#282828;'><td class='padding'><textarea name=why style='width:380px;height:100px;background:black;color:yellow;'></textarea></td></tr>
<tr style='background:#282828;'><td class='paddingc'>
<br>* Всі поля повинні бути заповнені. Після 
<br>заповнення анкети з вами буде (можливо ;)
<br>проведена співбесіда. <br>
<br></td></tr>
<tr style='background:#282828;'	><td style='text-align:center;'>
<input type=submit value='Надіслати' name='register'> 
<input type=button value='Назад' name='back' onclick='document.location.href="enter.php"'>
</td></tr>
</form>
</table></div>


</td></tr>
</table>
