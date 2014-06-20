<?
	include_once "./files/common.php";
	include_once "./users/users.php";
	
	$user = CheckUser();
	if( !$user ) die();
	echo "Welcome ".$user['uNick'];
	
	$sql = "SELECT fPid FROM forums WHERE fId=55";
	$res = uquery($sql);
	$pid = mysql_result($res, 0, 0);
	
	$sql = "INSERT INTO forums VALUES(NULL, 'Solaris', 'Sun microsystems', now(), $pid, 0)";
//	echo uquery($sql);

	//DeleteUserFromAll( 109 );
?>