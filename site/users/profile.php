<?
	include_once "../files/common.php";
	include_once "users.php";  

	$user = CheckUser();
	if(!$user) EchoErrorMsg("�� �� ���������������� ����������","../users/enter.php");
?>

<br><br><br><br><center>
<div class='frmframe' style='width:500px;'><table class='frmlist' cellspacing='0'>
<form action='../users/saveprof.php' method='post'>
<tr class='frmttl'><td class='padding' colspan='2'>User profile</td>
<tr><td style='vertical-align:middle;'>

<tr><td class='profkey'>����������: </td><td><input style='width:100%' type='text' name='nick' value='<?=$user['uNick'];?>' readonly></td></tr>
<tr><td class='profkey'>���������� ������: </td><td><input style='width:100%' type='text' name='mail' value='<?=$user['uMail'];?>'></td></tr>
<tr><td class='profkey'>������: </td><td><input style='width:100%' type='password' name='pswd'></td></tr>
<tr><td class='profkey'>ICQ: </td><td><input style='width:100%' type='text' name='icq' value='<?=$user['uICQ'];?>'></td></tr>
<tr><td class='profsmall' colspan='2'> * ������� ���� ������� ���� �������� ��������</td></tr>
<tr><td class='profkey'>�����: </td><td><select name="style"  style='width:100%'>
<?
	$styles = GetStyles();
	foreach($styles as $v) echo "<option value='{$v['stId']}' ".($v['stId']==$user['uStyle'] ? "selected" : "").">{$v['stName']}</option>";
?>
</select></td></tr>
<tr><td class='profkey'>Signature: </td><td><input style='width:100%' type='text' name='signature' value='<?=$user['uSignature'];?>'></td></tr>
<tr><td colspan='2'  class='profkey' style='text-align:center;'><input type='submit' value=' �������� '></td></tr>
</form></table></div>
<br>

<div class='frmframe' style='width:500px;'><table class='frmlist' cellspacing='0'>
<tr class='frmttl'><td class='padding' colspan='2'>��������</td>
<tr class='profkey'><td class='padding'><center>
<form action='../users/setavatar.php' method='post' enctype='multipart/form-data' target='main'>
������� ���� ��������:<br>
<input type='file' name='ava'><br>
<input type='submit' value='�����������'>
</form><br>
<div style='font-weight:normal;'>���������: 100Kb, 140x100, png</div>
</td>
<td class='padding'><?="<img src='../img/avatars/".GetUserAvatar($user['uId'])."'>";?></td></tr>

</table></div>