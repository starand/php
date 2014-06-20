<?
	include_once "common.php";
	include_once "../forums/forums.php";
	include_once "../users/users.php";
	
	if(!($user=CheckUser())) EchoErrorMsg("","../users/enter.php");

	echo "<br><center><div class='frmframe' style='width:700px;'><table class='frmlist' cellspacing='1' style='font-size:10px;'>";
	echo "<tr class='frmttl'><td class='padding' colspan='3'><b>Reminders</b></td></tr>";
	
	$i = 1;
	$list = GetUserReminders( $user['uId'], 100 );
	if( $list ) foreach( $list as $v )
	{
		echo "<tr class='smpad' style='background:#".($i%2 ? "282828" : "333333").";'>";
		echo "<td class='smpad' style='width:100px;'>[{$v['rTime']}]</td>";
		echo "<td class='smpad' style='color:magenta;'>{$v['rMsg']}</td>";
		echo "<td class='smpad' style='width:18px;'><a href='../files/actions.php?rid={$v['rId']}&del=1' target='actions' class='red'>[x]</a></td>";
		echo "</tr>";
		++$i;
	}
	echo "</table></div>";
	echo "<BR>";
?>
<div class='frmframe' style='width:500px;'><table class='frmlist' cellspacing='1' style='font-size:10px;'>
<tr class='frmttl'><td class='padding' colspan='3'><b>Add reminder</b></td></tr>

<form target='actions' action='../files/actions.php'>
	<tr><td class='smpad' style='background:#333333;text-align:center;'>
		<input type='text' style='width:100%;' name='rmsg'>
		Press Enter to add reminder
	</td></tr>
</form>
		
</table></div>	