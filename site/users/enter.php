<?
	include_once "../files/common.php";
	include_once "users.php";
	
	if( false && !isset($_GET['enter']) ) {
		include_once "../blog/index.php";
		die();
	}
?>
<HEAD><LINK href='/themes/green/main.css' rel=stylesheet type=text/css>
<meta http-equiv='Content-Type' content='text/html; charset=windows-1251'></HEAD>

<table height="100%" width="100%" style="vertical-align:middle;text-align:center;">
<tr><td style='vertical-align:middle;text-align:center;'>
<?
	if(!isset($msg)) if(isset($_POST['msg'])) $msg = $_POST['msg'];
	else if(isset($_GET['msg'])) $msg = $_GET['msg'];
	else if(!isset($msg)) $msg = "";
	echo "<div class='warning'>$msg</div>";
?>

<center><h2 style='color:green;'>Don't Learn to HACK - Hack to LEAR<a href='enter.htm' style='color:green;text-decoration:none;cursor:default;'>N</a></h2>

</td></tr>
</table>

<br>