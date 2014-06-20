<?
	include_once "common.php";
	include_once "../forums/forums.php";
	include_once "../users/users.php";
	
	if(!($user=CheckUser())) EchoErrorMsg("","../users/enter.php");
	
	$pf = GetForums(0);
	$count = count($pf);
	$i = 1;
	foreach($pf as $f)
	{
		echo "<div class='frmframe'><table class='frmlist' cellspacing='1'>";
		echo "<tr class='frmttl'><td class='frmttl' colspan='1'>{$f['fName']}</td></tr>";
		$flist = GetForums($f['fId']);
		foreach($flist as $sf)
		{
			echo "<tr class='frmcont'><td class='frmcont'><b class='underline'>{$sf['fName']}</b>";
			echo ( $sf['fDesc'] ? "<br><span class='frmcomment'>{$sf['fDesc']}</span>" : "")."<br>";
			$sflist = GetForums($sf[0]);
			foreach($sflist as $ssf) 
				echo "<a class='underline' href='../files/main.php?script=showforum&fid={$ssf[0]}'><img src='../img/sub.png'>{$ssf['fName']}</a> &nbsp; ";
			echo "</td>"./*<td class='frmcount'>".GetThemeCount($sf[0])." тем</td>";
			echo "<td class='frmcount'>".GetMessageCount($sf[0])." повідомлень</td>";
			$lm = GetLastMessage($sf[0]);
			echo "<td class='frmlastmsg'>Останнє повідомленння - {$lm['Date']}<br>";
			echo "в <a href='../files/main.php?script=showmsg&mid={$lm['mPmsg']}#id{$lm['mId']}'>{$lm['mTheme']}</a>";
			echo " від ".alink($lm)."</td>*/"</tr>";
		}
		echo "</table></div>";
		if($i != $count) echo "<table><tr style='height:2px;'></tr></table>";
		$i++;
	}
?>