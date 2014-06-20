<?	
	include_once "../files/common.php";
	include_once "forums.php";
	include_once "../users/users.php";
	
	if(!($user=CheckUser())) EchoErrorMsg("","../users/enter.php");
	if( $user['uLevel'] != 255 ) EchoErrorMsg("Access denied");
	
	$mid = (int)$_GET['mid'];
	$fid = (int)$_GET['fid'];
	
	if( !$mid || !$fid ) EchoErrorMsg("Data pass error");
	
	ChangeMsgForum($mid, $fid);
	EchoErrorMsg("", "/files/main.php?script=showmsg&mid=$mid");
?>