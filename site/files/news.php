<?
	include_once "common.php";
	include_once "../forums/forums.php";
	include_once "../users/users.php";
	
	if(!($user=CheckUser())) EchoErrorMsg("","../users/enter.php");
	
	$msgs = GetNews(10);
	
	echo "<div class='frmframe'><table class='frmlist' cellspacing='1' style='font-size:10px;'>";
	echo "<tr class='frmttl'><td class='padding'><b>News</b> <a title='more' href='/files/main.php?script=news'>..</a>";
	if($user['uLevel']==255) 
	{
		echo "<span style='float:right;'>";
		echo "<a href='/files/main.php?script=showmsg&mid=150'>[view]</a> ";
		echo "<a href='/files/main.php?script=addmsg&mPmsg=150&fid=5'>[add]</a>";
		echo "</span>";
	}
	echo "</td></tr>";
	
	
	$daysNow = GetToDaysNow();
	if($msgs) foreach($msgs as $msg) 
	{
		$pm = 0;
		if($msg['mTheme'] === "")
		{
			$pm = GetMsg($msg['mPmsg']);
			if($pm) $msg['mTheme'] = "Re: {$pm['mTheme']}";
		}
		
		$color = "282828";
		switch($daysNow - $msg['mDays'])
		{
		case 0:  $color = "700000"; break;
		case 1:  $color = "600000"; break;
		case 2:  $color = "500000"; break;
		case 3:  $color = "400000"; break;
		case 4:  $color = "300000"; break;
		}
	
		echo "<tr style='background:#$color'> ";
		echo "<td class='padding'>{$msg['mMsg']}";
		echo "<span style='float:right;font-size:8px;margin-top:2px;'>{$msg['mDate']}";
		echo " &nbsp; <a href='/files/main.php?script=addmsg&eMsg={$msg['mId']}'>[e]</a></span></td></tr>";
	}

	echo "</table></div>";	
?>