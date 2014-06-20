<?
	include_once "../files/common.php";
	include_once "../users/users.php";
	include_once "forums.php";
	
	if(!($user=CheckUser())) EchoErrorMsg("","../users/enter.php");

	if( !isset($_GET['mid']) ) die();
	$mid = (int)$_GET['mid']; if( !$mid ) die();
	
	if( isset($_GET['fid']) && (int)$_GET['fid'] )
	{
		$fid = (int)$_GET['fid'];
		AttachFile($mid, $fid);		
	}
	
	if( isset($_GET['did']) && (int)$_GET['did'] )
	{
		$did = (int)$_GET['did'];
		DeleteAttachedFile($did);
	}
	
	$attached_list = GetAttacFilesList($mid);
	if( $attached_list ) 
	{
		echo " &nbsp; <span class='attached_ttl'>Attached files: </span> ";
		foreach($attached_list as $af) 
		{
			echo " <a onClick='DeleteAttachFile($mid,{$af['afId']});' title='delete attach' class='attached'>{$af['fileName']}</a> &nbsp; ";
		}
	}
?>