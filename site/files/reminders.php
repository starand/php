<?
	include_once "common.php";
	include_once "../forums/forums.php";
	include_once "../users/users.php";
	
	if(!($user=CheckUser())) EchoErrorMsg("","../users/enter.php");
	
	$msgs = GetUserReminders($user['uId'], 4);
	if( $msgs )
	{
		echo "<span style=';text-align:right;color:magenta;float:right;'>";
		foreach( $msgs as $msg )
		{
			echo $msg['rMsg'];
			echo " <a style='color:red;' href='../files/actions.php?rid={$msg['rId']}&del=1' target='actions'>[x]</a><br>";
		}
		echo "</span>";
	}
?>