<?
	include_once "../files/common.php";
	include_once "../users/users.php";
	include_once "forums.php";
	
	if(!($user=CheckUser())) EchoErrorMsg("","../users/enter.php");
	
	if( !isset($_GET['mid']) ) die();
	$mid = (int)$_GET['mid']; if( !$mid ) die();
	
	$list = GetUserUploadFiles( $user['uId'] );

	if( $list ) foreach($list as $f)
	{
		echo "<a class='attach' onClick='AttachFile($mid,{$f['fileId']})'>{$f['fileName']}</a> &nbsp; ";
	}
	else echo "You don't have any upload files";
		
?>
