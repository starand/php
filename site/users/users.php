<?
//********** USERS FUNCTION **********
// add new user
function AddUser($nick,$pass,$mail,$ip,$style)
{
	$query = "INSERT INTO users (uNick,uPswd,uMail,uRegDate,uLastDate,uIp,uStyle) VALUES ('$nick',md5('$pass'),'$mail',now(),now(),'$ip',$style)";
	uquery($query);
}
// GetUser
function GetUser($id)
{
	$query = "SELECT * FROM users WHERE uId=$id LIMIT 1";
	$res = uquery($query);	
	if($res && mysql_num_rows($res)) return mysql_fetch_array($res);
	else return 0;
}
// GetUser by enter code
function CheckEnterCode($code)
{
	$query = "SELECT * FROM users WHERE uEnterCode='$code' LIMIT 1";
	$res = uquery($query);	
	if($res && mysql_num_rows($res)) return mysql_fetch_array($res);
	else return 0;
}
// Get user name by id
function GetUserName($id)
{
	$query = "SELECT uNick FROM users WHERE uId=$id LIMIT 1";
	$res = uquery($query);	
	if($res && mysql_num_rows($res)) return mysql_result($res,0,0);
	else return 0;
}
// Get User by Nick
function GetUserByNick($nick)
{
	$query = "SELECT * FROM users WHERE uNick='$nick' LIMIT 1";
	$res = uquery($query);	
	if($res && mysql_num_rows($res)) return mysql_fetch_array($res);
	else return 0;
}
// check session information
function CheckUser()
{
	if(isset($_SESSION["n_user"])) return $_SESSION["n_user"];
	else return 0;
}
## change password
function SetPassword($uid,$pass)
{
	$query = "UPDATE users SET uPswd=md5('$pass') WHERE uId=$uid";
	return uquery($query);
}
## change main
function SetMail($uid,$mail)
{
	$query = "UPDATE users SET uMail='$mail' WHERE uId=$uid";
	return uquery($query);
}
## change main
function SetICQ($uid,$icq)
{
	$query = "UPDATE users SET uICQ='$icq' WHERE uId=$uid";
	return uquery($query);
}
## change signature
function SetSignature($uid,$signature)
{
	$query = "UPDATE users SET uSignature='$signature' WHERE uId=$uid";
	return uquery($query);
}
## update user ip on enter
function UpdateIp($uid,$ip)
{
	$query = "UPDATE users SET uIp='$ip', uLastDate=now(), uChatLastMsg=0 WHERE uId=$uid";
	return uquery($query);
}

## update last time on site
function UpdateLastTime($uid)
{
	$query = "update users set uLastDate=now() where uId=$uid";
	return uquery($query);
}

## get active users
function GetActiveUsers()
{
	$query = "select * from users where (now()-uLastDate) <= 300";
	$res = uquery($query);	
	for($result=array(); $row=mysql_fetch_array($res); $result[]=$row);
	if($res && mysql_num_rows($res)) return $result;
	return 0;
}
## change enter code
function SetEnterCode($uid,$code)
{
	$query = "UPDATE users SET uEnterCode='$code' WHERE uId=$uid";
	return uquery($query);
}
// GetUser
function GetUsers($limit=0, $skip=0)
{
	$limitstr = "";
	if($limit > 0) $limitstr = "LIMIT $skip, $limit";
	$query = "SELECT * FROM users WHERE uId>0 ORDER BY uLevel DESC $limitstr";
	$res = uquery($query);
	for($result = array(); $usr = mysql_fetch_array($res); $result[] = $usr);
	if($res && mysql_num_rows($res)) return $result;
	else return 0;
}

function GetUserAvatar($uid)
{
	$sql = "SELECT uAvatar FROM users WHERE uId=$uid";
	$res = uquery($sql);
	if($res && mysql_num_rows($res))
	{
		return mysql_result($res, 0, 0);
	}
	else return "noimage.png";
}
function LastVisitToDays($uid)
{
	$sql = "SELECT TO_DAYS(now()) - TO_DAYS(uLastDate) as DaysAgo, SUBSTR(uLastDate, 12) as TimeAgo FROM users WHERE uId=$uid";
	$res = uquery($sql);
	if($res && mysql_num_rows($res))
	{
		$lv = mysql_fetch_array($res);
		if($lv['DaysAgo'] == 0) return "—ьогодн≥ ".$lv['TimeAgo'];
		else if($lv['DaysAgo'] == 1) return "1 день тому";
		else if($lv['DaysAgo'] < 5) return $lv['DaysAgo']." дн≥ тому";
		else return $lv['DaysAgo']." дн≥в тому";
	}
	return "давно :)";
}
function GetTodayUsers()
{
	$sql = "SELECT * FROM users WHERE ( TO_DAYS(NOW()) - TO_DAYS(uLastDate) ) = 0";
	$res = uquery($sql);
	for($result = array(); $usr = mysql_fetch_array($res); $result[] = $usr);
	if($res && mysql_num_rows($res)) return $result;
	else return 0;
}

function DeleteUserFromAll($uid)
{
	global $user;
	if( $user['uLevel'] != 255 ) return;
	
	echo "<BR>Deleting user messages .. ";
	uquery( "update msgs set mUid=2 where mUid=$uid" );
	echo "<BR>Deleting user files .. ";
	uquery( "update files set fileUid=2 where fileUid=$uid" );
	echo "<BR>Deleting user karma .. ";
	uquery( "update karma set krmFuid=2 where krmFuid=$uid" );
	echo "<BR>Deleting user logs .. ";
	uquery( "update log set logUid=2 where logUid=$uid" );
	echo "<BR>Deleting user .. ";
	uquery( "delete from users where uId=$uid" );
	echo "<BR>Deleting user fast_links .. ";
	uquery( "delete from fast_links where flUid=$uid" );
}

function GetMailList()
{
	$sql = "SELECT uMail FROM users WHERE uMail LIKE '%@%.%'";
	$res = uquery($sql);
	for($result = array(); $row = mysql_fetch_array($res); $result[] = $row['uMail']);
	if($res && mysql_num_rows($res)) return $result;
	return 0;
}

function SendMailToAll($subject, $text)
{
	// To send HTML mail, the Content-type header must be set
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= 'From: Safety Lab <admin@slab.zapro.org>' . "\r\n";

	//$mails = GetMailList();
	$mails = array("starand@ukr.net");
	foreach($mails as $mail)
	{
		$hdrs = $headers . "To: $mail\r\n";
		mail( $mail, $subject, $text, $hdrs) or die("Error on sending mail :<br><pre>\n$mail\n$hdrs</pre>");
	}	
}
?>