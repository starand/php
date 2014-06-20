<?
	include_once "../files/common.php";
	include_once "users.php";  
	
	$user = CheckUser();
	if(!$user) EchoErrorMsg("Ви не аутентифікований користувач","../users/enter.php");
	if(!isset($_GET['uid'])) EchoErrorMsg("Не вибраний користувач");
	else $uid = (int)$_GET['uid'];
	
	$usr = GetUser($uid); if(!$usr) EchoErrorMsg("Не вибраний користувач");
?><a style='color:magenta;' class=path href='/files/main.php?script=userprof&uid=<?=$uid;?>'><?=$usr['uNick'];?></a>

<center><br><br>
<div class='frmframe' style='width:600px;'><table class='frmlist' cellspacing='0'>
<tr class='frmttl'><td class='profttl' colspan='3'><?=$usr['uNick'];?></td></tr>
<tr><td class='proftag'>Ім'я:</td><td class='profvalue'><?=$usr['uNick'];?></td><td rowspan='9' class='profavatar'>
	<img src='../img/avatars/<?=$usr['uAvatar'];?>'></td></tr>
<tr><td class='proftag'>Повідомлень:</td><td class='profvalue'><?=GetUserMsgCount($uid);?></td></tr>
<tr><td class='proftag'>Статус:</td><td class='profvalue'><?=$usr['uLevel'];?></td></tr>
<tr><td class='proftag'>Дата реэстрації:</td><td class='profvalue'><?=ConvertDate($usr['uRegDate']);?></td></tr>
<tr><td class='proftag'>Остання активність:</td><td class='profvalue'><?=ConvertDate($usr['uLastDate']);?></td></tr>
<tr><td class='proftag'>Карма:</td><td class='profvalue'><?=GetUserKarma($usr['uId']);?></td></tr>
<tr><td colspan=2><hr></td></tr>
<tr><td class='proftag'>ICQ:</td><td class='profvalue'><?=$usr['uICQ'];?></td></tr>
<? if($user['uId'] == 1 || $user['uId'] == $usr['uId']) { ?>
<tr><td class='proftag'>eMail:</td><td class='profvalue'><?=$usr['uMail'];?></td></tr>
<tr><td class='proftag'>IP:</td><td class='profvalue'><a href='../files/main.php?script=geoip&ip=<?=$usr['uIp'];?>'><?=$usr['uIp'];?></a></td></tr>
<? } ?>
<tr class='frmttl'><td class='frmttl' colspan='3'>Додаткова інформація</td></tr>
<tr><td class='proftag' colspan='3'><a href='../files/main.php?type=0&script=dosearch&fstr=%25&usr=<?=$usr['uNick'];?>'>Показати повідомлення користувача</a></td></tr>

</table></div>


