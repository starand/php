<?
	include_once "common.php";
	include_once "../forums/forums.php";
	include_once "../users/users.php";
	
	if(!($user=CheckUser())) EchoErrorMsg("","../users/enter.php");
	
#################### REMINDER ACTIONS ####################
// delete reminder
	if( isset($_GET['rid']) && isset($_GET['del']) )
	{
		$rid = (int)$_GET['rid'];
		DeleteReminder( $user['uId'], $rid );
	}
// add reminder
	if( isset($_GET['rmsg']) )
	{
		$msg = DelXSS( $_GET['rmsg'] );
		AddReminder( $user['uId'], $msg );
	}
?>
<script>
parent.main.document.location.reload();
</script>