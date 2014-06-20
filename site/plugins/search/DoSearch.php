<?
	include_once "../files/common.php";
	include_once "../users/users.php";
	include_once "../forums/forums.php";
	include_once "search.php";

	if(isset($_GET['usr'])) $usr = $_GET['usr'];
	if(isset($_GET['fstr'])) $fstr = $_GET['fstr'];
	if(isset($_GET['type'])) $type = $_GET['type'];

	if(!isset($fstr))
	{
		$_SESSION['script'] = "search";
		EchoErrorMsg("Не вказані слова пошуку");
	}
	if($fstr=="") $fstr="%";
	$_SESSION['find_str'] = $fstr;
	$fstr = str_replace("|","\|",$fstr);
	$fstr = str_replace(")","\)",$fstr);
	$fstr = str_replace("(","\(",$fstr);

	if(isset($type) && $type==0) define("_SIMPE_FIND_","1"); 
	if(isset($usr) && $usr=GetUserByNick($usr)) $uid=$usr['uId']; else $uid=0;
	$sres = ForumSearch($fstr,$uid);	
	$count = 0;
	AddLogMsg($user['uId'], $fstr,107);
	
	echo "<a style='color:magenta;' class=path href='javascript:void();'>Результати пошуку</a><br><br>";
	
	if($sres) foreach($sres as $v) $count++;
	echo "Кількість: $count";
	echo "<div class='frmframe'><table class='frmlist' cellspacing='1' style='background:black;'>";
	echo "<tr class='frmttl'><td class='profttl'>Тема</td><td class='profttl'>Автор</td>
			<td class='profttl'>Дата</td></tr>";
	
	if(!$sres) echo "<TR><td colspan='3' class='srchdate'>Пошук не дав результату. Спробуйте змінити рядок пошуку.</td></tr>";
	else if( count($sres) == 1 ) 
	{
		$mid = $sres[0]['mId'];
		$pmsg = GetMsg($sres[0]['mPmsg']);
		EchoErrorMsg("", "main.php?script=showmsg&mid=".($pmsg ? "{$pmsg['mId']}#id" : "")."$mid");
	}
	else foreach($sres as $v) { OutResult($v, $fstr,"forums/OutMsg.php?mid=",++$count); }

	
	
	if(isset($_SESSION['search'])) unset($_SESSION['search']);	
	
	echo "</table></div>";
?>
