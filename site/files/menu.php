<?
	include_once "common.php";
	include_once "../users/users.php"; 

	$user = CheckUser(); if(!$user) die();
    $_CONFIG = GetConfig();
?>

<table class='frmlist'><tr><td class='menu'><span style='float:left;'>
<a class='ttl' href='../files/main.php?script=main' title=''> ������� </a> | 
<a class='ttl' href='../files/main.php?script=search' title=''> ����� </a> | 
<a class='ttl' href='../files/main.php?script=news' title=' '> ������ </a> | 
<a class='ttl' href='../files/main.php?script=lastmsgs' title=' '> ������ ����������� </a> | 
<a class='ttl' href='../files/main.php?script=userlist' title=' '> ����������� </a>
&nbsp;  &nbsp; 
<a class='ttl' href='../files/main.php?script=hash' title=' '> ���� </a> | 
<a class='ttl' href='../files/main.php?script=peoples' title=' '> ���� </a> | 
<a class='ttl' href='../files/main.php?script=fileslist' title=' '> Files </a> | 
<? 
    if ($_CONFIG['showBooks'] != 0) echo "<a class='ttl' href='../files/main.php?script=books' title=' '> ����� </a> | ";
    if ($_CONFIG['showReminders']) echo "<a class='ttl' href='../files/main.php?script=reminders' title=' '> Reminders </a> | ";
?>
 &nbsp;  &nbsp;
<a class='ttl' href='../files/main.php?script=profile' title=' '> ������� </a> | 
<a class='ttl' href='../users/logoff.php' title=''> ����� </a>

</span>
<?
	echo "<span id='fastlinks' style='float:right;'>";
	if ($_CONFIG['showQLinks'])
		include_once "../forums/fastlinks.php";
	echo "</span>";
?>
</td></tr></table>

<!--
<span style='position:absolute; top:1px; right:1px;'>Search: <input type='text' name='search' style='font-size:10px;' onKeyPress='return search(this.value,event)'></span>
-->


<script>
function search(str,e)
{
	var keycode;
	if (window.event) keycode = window.event.keyCode;
	else if (e) keycode = e.which;
	else return true;
	if (keycode == 13)
	{
		parent.main.document.location.href = 
			'/files/main.php?fstr='+str+'&usr=*&type=0&script=dosearch';		
		return false;
	}
	else return true;
}
</script>