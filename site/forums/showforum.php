<?
	include_once "../files/common.php";
	include_once "forums.php";
	if(!($user=CheckUser())) EchoErrorMsg("","../users/enter.php");
	if(isset($_GET['fid'])) $_SESSION['fId'] = (int)$_GET['fid'];
	if(!isset($_SESSION['fId'])) die(); else $fId=$_SESSION['fId'];
	
	$pf = $f = GetForum($fId); if(!$f) die();
	$fout = "";
	while($pf) 
	{
		$fout = "<a style='color:magenta;' class=path href='/files/main.php?script=".$_SESSION['script']."'>".$pf['fName']."/</a>".$fout;
		$pf = GetForum($pf['fPid']);
	}
	ShowPrompt( $fout );

?>
<div class='frmframe'><table class='frmlist' cellspacing='1'>
<tr class='frmttl'><td class='padding'>Тема</td><td class='padding' style='text-align:center;'>Автор</td>
<td class='padding'>Відповідей</td><td class='padding'>Переглядів</td><td class='padding'>Останнє повідомлення</td><tr>
<?
	if(!isset($_GET['page'])) $page = 0;
	else $page = (int)$_GET['page'];
	
	$limit = 20;
	$skip = $page * $limit;
	
	$count = GetMsgsCount($fId, 0);
	$page_count = $count / $limit;
	
	$msgs = GetMsgs($fId, 0, "desc", $skip, $limit);
	
	if($msgs) foreach($msgs as $v)
	{
		if( $v['mFid'] == 61 && $user['uId'] !== $v['mUid'] ) continue;
		$sm = GetLastAnswer($v['mId']);
		
		echo "<tr><td class='msglist' style='background:#282828;'>";
		echo "<a href='../files/main.php?script=showmsg&mid={$v['mId']}#id".LastAnswerId($v['mId'])."'>".MakeTDLink($v['mTheme'])."</a></td>";
		echo "<td class='msgautor'>".alink($v)."</td>";
		echo "<td class='msgcount'>".GetAnswerCount($v['mId'])."</td><td class='msgcount'>{$v['mCount']}</td>";
		echo "<td class='frmlastmsg' style='width:160px;'>{$sm['Date']}<br>від ".ALink($sm)."</td></tr>";
	}
	else echo "<tr><td class='msglist' style='background:#282828;text-align:center;' colspan='5'>Поки що даний форум пустий. Ви можете додати перше повідомлення</td></tr>";
?>
</table></div>
<BR>
<div class='frmframe'><table class='frmlist' cellspacing='0'>
<tr class='msgpanel'><td class='msgpanel'>Сторінка 
<?
	for($i = 0; $i < $page_count; $i++) 
	{
		echo "<a href='../files/main.php?script=showforum&fid=$fId&page=$i'";
		if($i == $page) echo " style='color:magenta;' ";
		echo ">[".($i+1)."]</a> ";
	}
?>
</td><td class='msgpanelsm'>
	<a href='../files/main.php?script=addmsg&mPmsg=0' style='color:white;'>Нова тема</a>
</td></tr>

</table></div>

