<HEAD><meta http-equiv='Content-Type' content='text/html; charset=windows-1251'>
<link rel="shortcut icon" href="favicon.ico" />

<?
	if( !isset($_GET['blog']) )
	{
		echo "<title>Safety Lab</title></HEAD>";
		echo "<script language=javascript src='files/index.js'></script>";
		echo "<script>var timer, msgs = new Array(), llm;</script>";
	}
	else
	{
		echo "<title>BLogs</title></HEAD>";
		echo "<script language=javascript src='blogs/index.js'></script>";
	}
?>