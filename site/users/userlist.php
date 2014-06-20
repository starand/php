<?
	include_once "../files/common.php";
	include_once "users.php";  
	
	$user = CheckUser();
	if(!$user) EchoErrorMsg("Ви не аутентифікований користувач","../users/enter.php");
	
	$ul = GetUsers();
	echo "<br><br><center><div class='frmframe' style='width:400px;'><table class='frmlist' cellspacing='0'>";
	echo "<tr class='frmttl'><td class='paddingc'>#</td>";
	echo "<td class='paddingc'>Name</td><td class='paddingc'>Last Login</td></tr>";
	$i = 1;
	foreach($ul as $usr)
	{
		echo "<tr style='background:#".($i%2 ? "282828" : "333333")."'><td class='paddingc'>$i</td>";
		echo "<td class='paddingc'><a href='../files/main.php?script=userprof&uid={$usr['uId']}'>{$usr['uNick']}</a></td>";
		echo "<td class='paddingc'>".ConvertDate($usr['uLastDate'])."</td></tr>";
		
		$i++;
	}
	echo "</table></div>";
?>


