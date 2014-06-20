<?	
	include_once "../files/common.php";
	include_once "forums.php";
	include_once "../users/users.php";
	
	if(!($user=CheckUser())) EchoErrorMsg("","../users/enter.php");
	if( $user['uLevel'] != 255 ) EchoErrorMsg("Access denied");
	
	$mid = (int)$_GET['mid'];

	if( !$mid ) EchoErrorMsg("Data pass error");
	
	$msg = GetMsg($mid);
	$flist = GetChildForums();
	$forum = GetForum($msg['mFid']);
	
?><br><br><br><center>
<div class='frmframe' style='width:300px;'><table class='frmlist' style='background:#313131;' cellspacing='1'>
<tr class='frmttl'><td colspan='2' class='padding' style='text-align:center;font-weight:bold;'>Change Msg Forum</td></tr>
<form action='../forums/changeforum.php'>
<tr><td>Message :</td><td><input type='text' readonly value='<?="{$msg['mTheme']}";?>'></td></tr>
<tr><td>Current forum :</td><td><input type='text' readonly value='<?=$forum['fName'];?>'></td></tr>
<tr><td>Select forum :</td><td><select name='fid'><? foreach($flist as $f) echo "<option value='{$f['fId']}'>{$f['fName']}</option>"; ?></select>
<input type='hidden' name='mid' value='<?=$mid;?>'></td></tr>
<tr><td colspan='2'><input type='submit' value='Change'></td></tr>
</form>

</table></div>