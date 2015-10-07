<?
	include_once "common.php";
	include_once "../users/users.php"; 

	$user = CheckUser(); if(!$user) die();
    $_CONFIG = GetConfig();
?><a href='../files/main.php?script=main'><img src='../img/logo.png'></a>
<div class='frmframe'>
<table class='frmlist' cellspacing='1'>
<tr style='height:85px;'>
<td class='msglist' style='width:90px;' rowspan='2'><?=GetAvatarHTML();?></td>
<td class='msglist' style='font-size:10px;'>
	Привіт, <?=$user['uNick'];?>, у Вас <a href='/files/main.php?fstr=%25&usr=<?=$user['uNick'];?>&type=0&script=dosearch'><?=GetUserMsgCount($user['uId']);?> повідомлень</a> <br>
	<?
		$nl = GetNewMsgs();
	?>
	<a href='/files/main.php?script=newmsgs'>Показати повідомлення після вашого останнього візиту (<?=count($nl);?>)</a> <br>
	<? echo date("d.m.Y H:i:s"); ?>
</td>
</tr>

<? 
	if($user['uNick'] === "StarAnd")
	{
		echo "<tr><td class='msglist' style='text-align:right;color:red;'> | ";
        
        echo "<a class='ttl' href='/plugins/gold/' title='GOLD' target='_blank'> gold </a> | ";
		echo "<a class='ttl' href='../files/main.php?script=sources' title=''> src </a> | ";
		echo "<a class='ttl' href='../files/main.php?script=log' title=''> Лог </a> | ";
        if ($_CONFIG['showSmartHouse'])
            echo "<a class='ttl' href='http://safetylab.zapto.org/plugins/smh/' title='Smart House' target='_blank'> House </a> | ";
        if ($_CONFIG['showJarvis'])
            echo "<a class='ttl' href='http://safetylab.zapto.org/plugins/jarvis/?module=notify&list&debug' title='Jarvis' target='_blank'> Jarvis </a> | ";
		if($_CONFIG['showRadio']) 
			echo "<a class='ttl' href='../files/main.php?script=radio' title=''> Radio </a> | ";			
		echo "</td></tr>";
	}
?>

</table>
</div>
<div style='position:absolute;right:20px;top:20px;'>
<span style='color:orange;'>QSearch:</span> <input type='text' id='qsearch'>
</div>
<div style='position:absolute;right:250px;top:25px;color:magenta;' id='copypaste'>CopyPaste</div>

<script src='../forums/js/jquery.js'></script>
<script>
$(document).ready(function()
{
	$('#qsearch').keyup(function(key)
	{
		if( key.keyCode == 13 )
		{
			link = '../files/main.php?usr=*&type=0&script=dosearch&fstr=' + $("#qsearch").val();
			document.location.href = link;
		}
	});
	$('#copypaste').click(function(key)
	{
			link = '../files/main.php?script=addcpdata';
			document.location.href = link;
	});

});
</script>