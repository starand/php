<?
	include_once "../files/common.php";
	include_once "forums.php";
	include_once "../users/users.php";
	if(!($user=CheckUser())) EchoErrorMsg("","../users/enter.php");
	if(!isset($_GET['link'])) die("link not isset");
	$link = (int)$_GET['link'];
	if(!$link) die("link == 0");
	
	DelFastLink($link);
?>
<script>parent.frames.main.document.location.reload()</script>