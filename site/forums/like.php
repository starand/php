<?
	include_once "../files/common.php";
	include_once "forums.php";
	include_once "../users/users.php";
	
	if(!($user=CheckUser())) EchoErrorMsg("","../users/enter.php");
	
	$mid = 0; $bLike = 0;
	if( isset($_GET['like']) )
	{
		$like = (int)$_GET['like'];
		if( !$like ) die();
		$mid = $like;
		$bLike = 1;
	}
	
	if( isset($_GET['dislike']) )
	{
		$dislike = (int)$_GET['dislike'];
		if( !$dislike ) die();
		$mid = $dislike;
	}
	
	if( $mid )
	{
		SmartAddLike( $mid, $user['uId'], $bLike  ? 'l' : 'd' );
	}
	else
	{
		if( !isset($_GET['mid']) ) die();
		$mid = (int)$_GET['mid']; if( !$mid ) die();
	}

	$msg = GetMsg( $mid );
	if( !$msg ) die();
	
	$nLikes = GetLikesCount( $mid, 'l' );
	$nDisLikes = GetLikesCount( $mid, 'd' );

	echo "<a onClick='".( $msg['mUid'] != $user['uId'] ? "Like({$mid})" : "" )."'><span class='like' title='Like'>{$nLikes}</span> <img src='../img/like.gif' class='like'></a> ";
	echo "<a onClick='".( $msg['mUid'] != $user['uId'] ? "DisLike({$mid})" : "" )."'><span class='like' title='DisLike'>{$nDisLikes}</span> <img src='../img/dislike.gif' class='like'></a> ";
	

?>
