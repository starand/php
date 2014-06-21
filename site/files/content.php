<?
	include_once "../forums/forums.php";

	if(!($user=CheckUser())) EchoErrorMsg("","../users/enter.php");
    $_CONFIG = GetConfig();

	echo "<table style='width:100%;'><tr><td>";
		$ActUsers = GetActiveUsers();
		echo "<b>Online : </b>";
		foreach($ActUsers as $usr)
		{
			echo "<a href='../files/main.php?script=userprof&uid={$usr['uId']}'>{$usr['uNick']}</a> &nbsp; ";
		}
		
		$TodayUsers = GetTodayUsers();
		echo "  &nbsp; <span style='font-size:9px;'> ׁüמדמהם³ : ";
		foreach($TodayUsers as $usr)
		{
			echo "<a href='../files/main.php?script=userprof&uid={$usr['uId']}'>{$usr['uNick']}</a> &nbsp; ";
		}
		echo "</span> ";
		
		if(isset($_SESSION['n_new_msgs']) && is_array($_SESSION['n_new_msgs']) && count($_SESSION['n_new_msgs'])) 
		{
			echo " &nbsp; <a href=/files/main.php?script=newmsgs style='color:red;'>New Messages</a><br>";
		}
		
	echo "</td><td>";
		if ($_CONFIG['showReminders'])
			include_once  "reminders.php";
	echo "</td></tr></table>";

	ShowPrompt();
	
	echo "<table cellspacing='1' cellpadding='0' style='width:100%;'><tr><td>";
		include_once  "frmlist.php"; // FORUMS

	echo "</td><td> &nbsp; </td><td style='width:200px;'>";
        if ($_CONFIG['showBooks'])
        {
            include "rndbook.php"; // books
            echo "<BR>";
        }

		if ($_CONFIG['showLastMsgs'])
		{
			define( "SHORT_LIST", 1 );
			define( "LIMIT_LIST", 5 );
			include_once "../forums/lastmsgs.php";
		}
    
        if ($_CONFIG['showNews'])
        {
    echo "</td><td> &nbsp; </td><td style='width:200px;'>";        
            include_once "news.php"; // NEWS
        }
		
	echo "</td></tr></table>";

?>