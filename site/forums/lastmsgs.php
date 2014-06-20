<?
	include_once "../files/common.php";
	include_once "../users/users.php";	
	include_once "forums.php";	
	
	$bShort = defined( "SHORT_LIST" );
	$nLimit =20;
	if( defined( "LIMIT_LIST" ) ) $nLimit = LIMIT_LIST;

	if(!($user=CheckUser())) EchoErrorMsg("","../users/enter.php");

	$skip = 0;
	if(isset($_GET['skip'])) $skip = (int)$_GET['skip'];
	
	$i = 0;
	$msgs = GetLastMsgs($nLimit, $skip);
?>
<div class='frmframe'><table class='frmlist' cellspacing='1'>
<tr class='frmttl'><td class='padding'><? echo !$bShort ? "Тема" : "Last msgs <a href='/files/main.php?script=lastmsgs'>..</a>"; ?></td>
<? if( !$bShort ) { ?>
<td class='padding' style='text-align:center;'>Forum</td><td class='padding' style='text-align:center;'>Автор</td>
<td class='padding'>Переглядів</td><td class='padding' style='text-align:center;'>Час</td>
<? } ?>

<tr>
<?
	$daysNow = GetToDaysNow();
	if($msgs) foreach($msgs as $msg) 
	{
		$pm = GetMsg($msg['mPmsg']);
		if($msg['mTheme'] === "")
		{
			if($pm) $msg['mTheme'] = "Re: {$pm['mTheme']}";
		}
		if($msg['mPmsg'] != 0)
		{
			$msg['mCount'] = $pm['mCount'];
		}
		
		$frm = GetForum( $msg['mFid'] );
		
		$color = "282828";
		switch($daysNow - $msg['mDays'])
		{
		case 0:  $color = "700000"; break;
		case 1:  $color = "600000"; break;
		case 2:  $color = "500000"; break;
		case 3:  $color = "400000"; break;
		case 4:  $color = "300000"; break;
		}
		
		echo "<tr style='background:#{$color}'>";
        echo "<td class='padding' style='background:#{$color};'>";
        echo "<a href='../files/main.php?script=showmsg&mid=".($pm ? $pm['mId']."#id".$msg['mId'] : $msg['mId'])."'>";
        echo MakeTDLink("{$msg['mTheme']}");
        echo "</a> ";
		if( $bShort ) echo "[ ".alink($msg)." ]";
		echo "</td>";
        
	if( !$bShort ) {
		echo "<td class='msgcount'><a style='font-size:10px;color:magenta;' href='/files/main.php?script=showforum&fid={$msg['mFid']}'>[{$frm['fName']}]</a></td>";		
		echo "<td class='msgautor'>".alink($msg)."</td>";
		echo "<td class='msgcount'>{$msg['mCount']}</td>";
		echo "<td class='msgautor' style='width:160px;'>{$msg['Date']}</td>";
	}
		echo "</tr></tr>";
	}
?>
</table></div>