<?
	include_once "../files/common.php";
	include_once "../users/users.php"; 

	$user = CheckUser();
	if(!$user) die();	
	
	$fl = GetFastLinks();
	if($fl) foreach($fl as $link)
	{
		echo "<a href='../files/main.php?script=showmsg&mid={$link['flLink']}' style='color:#aaffaa;'>{$link['flName']}</a> ";
		echo " <a href='../forums/delflink.php?link={$link['flId']}' target='actions' style='color:#dddddd;'>[x]</a>&nbsp; ";
	}	
?>