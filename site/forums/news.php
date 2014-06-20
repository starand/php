<?
	include_once "../files/common.php";
	include_once "../users/users.php";	
	include_once "forums.php";	
	

	if(!($user=CheckUser())) EchoErrorMsg("","../users/enter.php");

	$skip = 0;
	if(isset($_GET['skip'])) $skip = (int)$_GET['skip'];
	
	$i = 0;
	$msgs = GetNews(20);
?>
<div class='frmframe'><table class='frmlist' cellspacing='1'>
<tr class='frmttl'><td class='padding'>Тема</td><td class='padding' style='text-align:center;'>Час</td></tr>
<?
	if($msgs) foreach($msgs as $msg) 
	{
		$pm = 0;
		if($msg['mTheme'] === "")
		{
			$pm = GetMsg($msg['mPmsg']);
			if($pm) $msg['mTheme'] = "Re: {$pm['mTheme']}";
		}
		echo "<tr style='background:#".($i%2 ? "282828" : "333333")."'>";
		echo "<td class='padding' style='background:#282828;'>{$msg['mMsg']}</td>";
		echo "<td class='msgautor' style='width:160px;'>{$msg['Date']}</td></tr></tr>";
	}
?>
</table></div>