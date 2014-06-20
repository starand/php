<?
	include_once "../files/common.php";
	include_once "../users/users.php";	
	include_once "forums.php";

	if(!($user=CheckUser())) EchoErrorMsg("","../users/enter.php");

	echo "<br>";
	
	$lm = &$_SESSION['n_new_msgs'];
	$lm = array_unique($lm);

	echo "<div class='frmframe'><table class='frmlist' cellspacing='1'>";
	echo "<tr class='frmttl'><td class='padding'>Тема</td><td class='padding' style='text-align:center;'>Форум</td>";
	echo "<td class='padding' style='text-align:center;'>Автор</td><td class='padding' style='width:160px;text-align:center;'>Час</td></tr>";
	
	function RemoveElement($value)
	{
		global $expr;
		return !($value === $expr);
	}
	
	$i = 1;
	if($lm) foreach($lm as $v)
	{
		$msg = GetMsg($v);
		
		if(!$msg) 
		{
			$expr = $v;
			$lm = array_filter($lm, "RemoveElement");
			continue;
		}
		
		$frm = GetForum($msg['mFid']);
		$tm = GetMsg($msg['mPmsg']);
		if($msg['mTheme'] === "") $msg['mTheme'] = $tm['mTheme'];
		
		if($msg['mPmsg'] == 0) $pm = $msg; // getting parent message - need for correct show msg thread
		else $pm = GetMsg($msg['mPmsg']);
		
		echo "<tr style='background:#".($i%2 ? "282828" : "333333")."'>";
		echo "<td class='padding'><a href=/files/main.php?script=showmsg&mid={$pm['mId']}#id{$msg['mId']}>".$msg['mTheme']."</a></td>";
		echo "<td class='paddingc'> [<a href=/files/main.php?script=showforum&fid={$msg['mFid']}>{$frm['fName']}</a>] </td>";
		echo "<td class='paddingc'> <a href='../files/main.php?script=userprof&uid={$msg['mUid']}'>{$msg['uNick']}</a>";
		echo "</td><td class='paddingc'>{$msg['Date']}</td></tr>";
		$i++;
	}
	else echo "<tr style='background:#282828;'><td class='paddingc' colspan='4'>Нових повідомлень немає</td></tr>";
	echo "</table></div>";

?>