<? include "common.php" ?>
<HEAD><meta http-equiv='Content-Type' content='text/html; charset=windows-1251'><LINK href='scheduler.css' rel=stylesheet type=text/css></HEAD>
<script src='jquery.js'></script>
<body><center>
<title>Scheduler Manager</title>
<? CheckUser(); ?>

	<div id='content'>
		<? include_once "schedules_list.php"; ?>
	</div>

</body> 