<?
	include_once "../files/common.php";
	include_once "../users/users.php";	
	include_once "forums.php";	

	if(!($user=CheckUser())) EchoErrorMsg("","../users/enter.php");
	if(!isset($_POST['mid']) || !isset($_POST['keyword'])) die("No actual params");
	
	$mid = (int)$_POST['mid'];
	$keyword = mb_convert_encoding($_POST['keyword'], "windows-1251", "utf-8");
	$keyword = DelXSS($keyword);
	
	$_SESSION['n_keyword'] = $keyword;
	$msgs = GetMsgsByKeyword($mid, $keyword);
	
	echo "<table class='frmlist' cellspacing='0' cellpadding='0' style='width:100%;'>";
	echo "<tr style='height:1px;'><td class=hline></td></tr>";
	if($msgs) foreach($msgs as $m)
	{	
		ShowMsg($m);
	}
	echo "</table>";
?>