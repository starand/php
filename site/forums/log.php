<?
	include_once "../files/db.php";
	include_once "../files/common.php";
	include_once "../users/users.php";	
	include_once "../forums/forums.php";
	include_once "../plugins/books/books.php";
	
	if(!($user=CheckUser())) EchoErrorMsg("","../users/enter.php");
	if(!isset($_GET["skip"])) $skip = 0; else $skip = (int)$_GET["skip"];
	
	define("_LOG_", 1);

	echo "<br>";
	if($skip > 0) echo "<a href='../files/main.php?script=log&skip=".($skip-($skip>40 ? 40 : $skip))."'> &lt; </a>";
	if($skip+40 < GetLogCount()) echo "<a href='../files/main.php?script=log&skip=".($skip+40)."'> &gt; </a>";
	
	$table_header = "<table style='font-size:10px;'><tr><td class='serv_ttl' style='font-size:12px;' colspan='3'>Ћог:</td></tr>";
	
	echo "<table><tr><td>$table_header";
	$q = "and logType<100";
	if( $user['uLevel']==255 ) $q = "";
	$sm = GetFullLogMsgs($q, 60,$skip);
	$i = 0;
	if($sm) foreach(
	
	$sm as $v)
	{
		$i++;
		ShowLogs($v);
		if( $i == 30 ) echo "</table></td><td>$table_header";
	}
	echo "</table></td></tr></table>";	
	
	
?>