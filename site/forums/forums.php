<?
function AddForum($fname, $fdesc, $fType=0)
{
	$query = "INSERT INTO forums (fName,fDesc,fType) VALUES('$fname','$fdesc',$fType)";
	uquery($query);
}
function GetForums($fid="fPid",$fType=0)
{
	$query = "select * from forums where fPid=$fid and fType=$fType order by fId";
	$res = uquery($query); 
	for($result=array(); $row=mysql_fetch_array($res); $result[]=$row);
	if($res && mysql_num_rows($res)) return $result;
	return 0;
}
function GetForum($fId) 
{
	$query = "select * from forums where fId=$fId";
	$res = uquery($query);	
	if($res && mysql_num_rows($res)) return mysql_fetch_array($res);
	return 0;
}
function GetFMsgCount($fId)
{
	$query = "select count(*) from msgs where mFid=$fId and mPmsg=0";
	$res = uquery($query);	
	if($res && mysql_num_rows($res)) return mysql_result($res,0,0);
	return 0;

}
function AddMsg($mUid,$mFid,$mPmsg,$mTheme,$mMsg,$mIp,$mOrigMsg="", $level=0)
{
	$mtype=0;
	if($mFid == 61) $mtype = 127;
	if($pmsg = GetMsg($mPmsg))	$mtype = $pmsg['mType'];
	$query = "insert into msgs (mUid,mDate,mFid,mPmsg,mTheme,mMsg,mIp,mOrigMsg,mType,mLevel) values($mUid,now(),$mFid,$mPmsg,'$mTheme','$mMsg','$mIp','$mOrigMsg',$mtype,$level)";
	uquery($query);
}
function DelMsg($mid, $uid)
{
	$query = "delete from msgs where mId=$mid and (muid=$uid or $uid=1)";
	return uquery($query);
}
function EditMsg($mId, $mMsg, $mOrigMsg, $level, $theme)
{
	$query = "UPDATE msgs SET mMsg='$mMsg', mOrigMsg='$mOrigMsg', mLevel=$level".(strlen($theme) ? ", mTheme='$theme'" : "")." where mId=$mId";
	return uquery($query);
}
function GetMsgs($fId="mfid",$pMsg=0,$order="asc", $skip=0, $limit=0)
{
	global $user;
	if($limit) $limit = " LIMIT $skip, $limit";
	else $limit = "";
	$query = "SELECT * FROM msgs,users WHERE mUid=uId AND mFid=$fId AND mPmsg=$pMsg and {$user['uLevel']}>=mLevel order by mDate $order $limit";
	
	if($limit != 0) $query.=" limit $limit";
	$res = uquery($query); 
	for($result=array(); $msg=mysql_fetch_array($res); )
	{
		if($msg['mLevel'] > $user['uLevel']) $msg['mMsg'] = "<br><div class='rc'>Для перегляду повідомлення потрібно мати level ".$msg['mLevel']."</div>";
		$msg['Date'] = ConvertDate($msg['mDate']);
		$result[]=$msg;		
	}
	if($res && mysql_num_rows($res)) return $result;
	return 0;
}
function GetMsgsCount($fId="mfid",$pMsg=0)
{
	global $user;
	$query = "SELECT count(1) FROM msgs WHERE mFid=$fId AND mPmsg=$pMsg and {$user['uLevel']}>=mLevel";
	$res = uquery($query);
	if($res && mysql_num_rows($res)) return mysql_result($res, 0, 0);
	return 0;	
}
function GetMsgsByKeyword($mid, $keyword)
{	
	global $user;
	$query = "SELECT * FROM msgs,users WHERE mUid=uId AND (mPmsg=$mid OR mId=$mid) AND mOrigMsg like '%$keyword%' 
			AND {$user['uLevel']}>=mLevel order by mDate $order LIMIT 100";
			
	$res = uquery($query); 
	for($result=array(); $msg=mysql_fetch_array($res); )
	{
		$msg['Date'] = ConvertDate($msg['mDate']);
		$result[]=$msg;		
	}
	if($res && mysql_num_rows($res)) return $result;
	return 0;
}
function GetToDaysNow()
{
	$sql = "select to_days(now())";
	$res = uquery($sql);
	if($res && mysql_num_rows($res)) return mysql_result($res, 0, 0);
	return 0;
}
function GetNews($limit = 8, $skip = 0)
{
	global $user;
	$query = "select *, to_days(mDate) as mDays from msgs where mPmsg=150 and {$user['uLevel']}>=mLevel and not(mFid=61 AND mUid<>{$user['uId']}) order by mDate desc limit $skip, $limit";
	$res = uquery($query); 
	for($result=array(); $msg=mysql_fetch_array($res); )
	{
		$msg['Date'] = ConvertDate($msg['mDate']);
		$result[]=$msg;
	}
	if($res && mysql_num_rows($res)) return $result;
	return 0;
}

function GetMsg($mId) 
{
	global $user;
	$query = "select * from msgs,users where mId=$mId and mUid=uId";
	$res = uquery($query);	
	if($res && mysql_num_rows($res)) 
	{
		$msg = mysql_fetch_array($res);
		$msg['Date'] = ConvertDate($msg['mDate']);
		if($msg['mLevel'] > $user['uLevel']) $msg['mMsg'] = "<br><div class='rc'>Для перегляду повідомлення потрібно мати level ".$msg['mLevel']."</div>";
		return $msg;
	}
	return 0;
}
function GetAnswerCount($pMsg)
{
	$query = "select count(*) from msgs where mPmsg=$pMsg";
	$res = uquery($query);	
	if($res && mysql_num_rows($res)) return mysql_result($res,0,0);
	return 0;	
}
function GetLastMsgTime($mId)
{
	$query = "select mDate from msgs where (mPmsg=$mId or mId=$mId) order by mdate desc limit 1";
	$res = uquery($query);	
	if($res && mysql_num_rows($res)) return substr(mysql_result($res,0,0),0,16);
	return "none";			
}
function GetMsgUser($uId)
{
	$query = "select uNick from msgs,users where mUid=uId and uId=$uId";
	$res = uquery($query);	
	if($res && mysql_num_rows($res)) return mysql_result($res,0,0);
	return 0;	
}
function GetSubMsgs($mId, $limit=0, $order = "asc")
{
	global $user;
	$query = "SELECT * FROM msgs,users WHERE mPmsg=$mId and mUid=uId order by mDate $order ".($limit ? "limit $limit" : "");
	$res = uquery($query); 
	for($result=array(); $msg=mysql_fetch_array($res); )
	{
		$msg['Date'] = ConvertDate($msg['mDate']);
		if($msg['mLevel'] > $user['uLevel']) $msg['mMsg'] = "<br><div class='rc'>Для перегляду повідомлення потрібно мати level ".$msg['mLevel']."</div>";
		$result[]=$msg;		
	}
	if($res && mysql_num_rows($res)) return $result;
	return 0;
}

function GetNextMsg($mid)
{
	$res = uquery("select mFid from msgs where mid=$mid");
	if(!mysql_num_rows($res)) return 0;
	$fid = mysql_result($res,0,0);
	$res = uquery("select mId from msgs where mFid=$fid and mid>$mid and mPmsg=0 order by mDate limit 1");
	if(!mysql_num_rows($res)) return 0;
	return mysql_fetch_array($res);
}
function GetPrevMsg($mid)
{
	$res = uquery("select mFid from msgs where mid=$mid");
	if(!mysql_num_rows($res)) return 0;
	$fid = mysql_result($res,0,0);
	$res = uquery("select mId from msgs where mFid=$fid and mid<$mid and mPmsg=0 order by mDate desc limit 1");
	if(!mysql_num_rows($res)) return 0;
	return mysql_fetch_array($res);
}

function AddReaded($mid)
{
	global $_SESSION;
	$_SESSION['n_readed'] .= $mid." ";
}

function DelReaded($mid)
{
	global $_SESSION;
	$nm = &$_SESSION['n_new_msgs'];
	if(isset($nm[$mid])) unset($nm[$mid]);
}

function ShowButtonPanel($msg)
{
	global $user;
	$pm = $msg['mPmsg'];
	if($msg['mPmsg'] == 0) $pm = $msg['mId'];
	
	// likes panel
	echo "<span id='likeCont{$msg['mId']}'></span>";

	echo "&nbsp; <a onClick='AddLink({$msg['mId']});' style='color:orange;text-decoration:none;' title='Додати в закладки'>[Закласти]</a> "; //<img src='../img/addfast.png'>
	echo "<a href='../files/main.php?script=addmsg&mPmsg=$pm&qid={$msg['mId']}' title='Цитата'>[Цитата]</a> "; // <img src='../img/quote.png'>
	if($msg['mUid'] != $user['uId']) 
		for($i=1; $i<2; $i++) 
		{
			echo "<a href='../forums/addkarma.php?mid={$msg['mId']}' target='actions' title='Оцінити'>[Оцінити]</a> "; // <img src='../img/good.png'>
		}
		
	if( $user['uLevel'] == 255 )
	{
		echo " <a title='Change msg forum' href='../files/main.php?script=changeforum&mid={$msg['mId']}&fid={$msg['mFid']}'>[Move]</a> ";
	}

	if($msg['mUid'] == $user['uId'] || $user['uLevel'] == 255) 
	{
		echo " <a href='../files/main.php?script=addmsg&eMsg={$msg['mId']}' title='Редагувати'>[Редагувати]</a> "; // <img src='../img/edit.png'>
		echo " <a target='actions' title='Видалити' onClick='DelRow(\"t{$msg['mId']}\", {$msg['mId']});'>[x]</a>"; // <img src='../img/del.png'>
		echo "&nbsp;";
	}
	
	
	if($msg['mPmsg']==0) 
	{
		if($m=GetPrevMsg($msg['mId'])) 
			echo "&nbsp;<a href=../files/main.php?script=showmsg&mid={$m['mId']} title='Попереднє повідомлення'> << </a>"; // <img src='../img/prev.png'>
		if($m=GetNextMsg($msg['mId'])) 
			echo " <a href=../files/main.php?script=showmsg&mid={$m['mId']} title='Наступне повідомлення'> >> </a>"; // <img src='../img/next.png'>
	}
}

function ShowMsg($msg)
{
	global $i;
	global $user;
	$i++;

	DelReaded($msg['mId']);
	
echo "<tr><td>";
	
	$pm = $msg['mPmsg'];
	if($msg['mPmsg'] == 0) $pm = $msg['mId'];
	
	// 	 NOTEPADS form     news msg main       news child msgs
	if($msg['mFid']==61 ||
		$msg['mStyle'] == 1) { ShowNoteMsg($msg); return; }
	
	echo "<table style='width:100%;' cellspacing=1 id='t{$msg['mId']}'>
			<tr style='background:#".($i%2 ? "282828" : "333333")."'>";
	echo "<td class='padding' style='width:150px; font-size:10px;'><a name='id{$msg['mId']}'></a>".alink($msg)."</td>";
	echo "<td class='padding'>";
		echo "<table style='width:100%;' cellpadding='0' cellspacing='0'>";
		echo "<tr style='font-size:10px;'><td><b>Тема повідомлення:</b> {$msg['mTheme']}</td>";
		echo "<td style='text-align:right;'>";
			ShowButtonPanel($msg);
		echo "</td></tr></table>";
	echo"</td></tr>";

	echo "<tr style='background:#".($i%2 ? "282828" : "333333")."'>";
	echo "<td class='padding'>";
	echo "<span style='font-size:10px;'>Був ".LastVisitToDays($msg['mUid'])."<br>";
	echo "Карма: ".GetUserKarma($msg['mUid'])."<br>Повідомлень: ".GetUserMsgCount($msg['mUid'])."</span><br><br>";

	echo "<img src='../img/avatars/".GetUserAvatar($msg['mUid'])."'>";
	echo "</td><td class='padding' id='d$i'>";
	
	$hdr = "";
	if( !$msg['mPmsg'] ) $hdr = "<h2>{$msg['mTheme']}</h2>";
	
	echo "<div class='msgcont'>$hdr{$msg['mMsg']}</div>";
	
	$files = GetAttachedFiles($msg['mId']);
	if($files)
	{
		echo "<hr><span class='atach_files'>Прикріплені файли: </span><span class='filelist'>";
		foreach($files as $f)
		{
			echo "<a href='/plugins/files/download.php?fid={$f['fileId']}' target='actions'>{$f['fileName']}</a> ";
		}
		echo "</span>";
	}
	echo "</td></tr>";
	
	echo "<tr style='background:#".($i%2 ? "282828" : "333333")."; font-size:10px;' id='t{$msg['mId']}'>";
	echo "<td class='padding'></td>";
	echo "<td class='padding'>";
		echo "<span style='float:left;color:#0080BF;font-weight:bold;'>{$msg['uSignature']}</span>";
		echo "<span style='float:right;'><b>Додано:</b> {$msg['Date']} &nbsp; </span>";
	echo "</td></tr></table>";
	
echo "</td></tr>";	
}

function GetQuickAnswerPanel()
{
	global $i;
	global $msg;
	$i++;

	echo "<div class='frmframe' style='width:90%;'><table class='frmlist' cellspacing='0'>";
	echo "<tr class='frmttl'><td class='msgttl'>Швидка відповідь</td></tr>";
	echo "<tr style='background:#".($i%2 ? "282828" : "333333")."'>";
	echo "<td class='padding'><b>Текс повідомлення</b></td></tr>";
	echo "<form action='../forums/addmsg.php?mPmsg={$msg['mId']}' method='post' target=''>";
	echo "<tr style='background:#".($i%2 ? "282828" : "333333")."'><td class='padding'>";
	echo "<textarea name='mMsg' id='message' cols='120' style='background:black;color:white; width: 100%;height: 70px;'></textarea></td></tr>";
	echo "<tr style='background:#".($i%2 ? "282828" : "333333")."'><td class='padding' style='text-align:center;'>";
	echo "<input type='hidden' name='mTheme' value='"."Re:".$msg['mTheme']."'>";
	echo "<input type='hidden' name='level' value='{$msg['mLevel']}'>";
	echo "<input type='hidden' name='save' value='1'><input type='hidden' name='edit' value='0'>";
	echo "<input type='submit' name='save' value=' Відіслати '> &nbsp;";
	echo "<input type='button' value='Стандартна відповідь' onClick='document.location.href=\"/files/main.php?script=addmsg&mPmsg={$msg['mId']}\"'> &nbsp;";
	echo "</td></tr></form>";
	echo "</table></div>";
}

function ShowButtons()
{
	global $langs;
	echo "<img src='/img/jj.gif' class='btnbbcode' onclick=\"surroundText('[justify]', '[/justify]')\" onmouseover=\"helpline('justify')\" onmouseout=\"helpline('tip')\"";
	echo "><img src='/img/jc.gif' class='btnbbcode' onclick=\"surroundText('[center]', '[/center]')\" onmouseover=\"helpline('center')\" onmouseout=\"helpline('tip')\"";
	echo "><img src='/img/jl.gif' class='btnbbcode' onclick=\"surroundText('[left]', '[/left]')\" onmouseover=\"helpline('left')\" onmouseout=\"helpline('tip')\"";
	echo "><img src='/img/jr.gif' class='btnbbcode' onclick=\"surroundText('[right]', '[/right]')\" onmouseover=\"helpline('right')\" onmouseout=\"helpline('tip')\"";
	echo "><input type=button class='btnbbcode' value=' B ' onclick=\"surroundText('[b]', '[/b]')\" onmouseover=\"helpline('b')\" onmouseout=\"helpline('tip')\"";
	echo "><input type=button class='btnbbcode' value=' I ' onclick=\"surroundText('[i]', '[/i]')\" onmouseover=\"helpline('i')\" onmouseout=\"helpline('tip')\"";
	echo "><input type=button class='btnbbcode' value=' IMG ' onclick=\"surroundText('[img]', '[/img]')\" onmouseover=\"helpline('img')\" onmouseout=\"helpline('tip')\"";
	echo "><input type=button class='btnbbcode' value=' Video ' onclick=\"surroundText('[video]', '[/video]')\" onmouseover=\"helpline('video')\" onmouseout=\"helpline('tip')\"";
	echo "><input type=button class='btnbbcode' value=' URL ' onclick=\"surroundText('[a]', '[/a]')\" onmouseover=\"helpline('a')\" onmouseout=\"helpline('tip')\"";
	echo "><input type=button class='btnbbcode' value=' Hide ' onclick=\"surroundText('[h]', '[/h]')\" onmouseover=\"helpline('h')\" onmouseout=\"helpline('tip')\"";
	echo "><input type=button class='btnbbcode' value=' h1 ' onclick=\"surroundText('[h1]', '[/h1]')\" onmouseover=\"helpline('h1')\" onmouseout=\"helpline('tip')\"";
	echo "><input type=button class='btnbbcode' value=' table ' onclick=\"surroundText('[table]', '[/table]')\" onmouseover=\"helpline('table')\" onmouseout=\"helpline('tip')\"";
	echo "><input type=button class='btnbbcode' value=' li ' onclick=\"surroundText('[li]', '[/li]')\" onmouseover=\"helpline('li')\" onmouseout=\"helpline('tip')\"";
	echo "><input type=button class='btnbbcode' value=' hr ' onclick=\"surroundText('[hr]', '')\" onmouseover=\"helpline('hr')\" onmouseout=\"helpline('tip')\"";
	echo "><input type=button class='btnbbcode' value=' br ' onclick=\"surroundText('[br]', '')\" onmouseover=\"helpline('br')\" onmouseout=\"helpline('tip')\">";
	
	$color = array( "FF0000", "FF8000", "FFFF00", "00FF00", "00FFBF", "0080BF", "4040BF", "8000BF", "BF40FF", "FF40FF", "FFFFFF", "000000" );
	foreach( $color as $col )
	{
		echo"<input type=button class='btnbbcode' onclick=\"surroundText('[color=#{$col}]', '[/color]')\" style='width:10px;background:#{$col};'>";
	}	

	echo "<br><input type=button class='btnbbcode' value=' Console ' onclick=\"surroundText('[console]', '[/console]')\" onmouseover=\"helpline('con')\" onmouseout=\"helpline('tip')\"";
	echo "><input type=button class='btnbbcode' value=' Code ' onclick=\"surroundText('[c]', '[/c]')\" onmouseover=\"helpline('c')\" onmouseout=\"helpline('tip')\">";
	foreach($langs as $l) echo "<input type=button class='btnbbcode' value=' $l ' onclick=\"surroundText('[$l]', '[/$l]')\" onmouseover=\"helpline('$l')\" onmouseout=\"helpline('tip')\">";
}

function ShowLogMsg($msg)
{
	echo "<tr><td colspan=2><a name='id{$msg['mId']}'><span style='color:grey;'>".sGetFDate($msg['mDate'])."</span> ";
	echo "<span style='font-weight:bold;color:magenta;'>{$msg['uNick']}</span>: &nbsp; ";
	echo $msg['mMsg']."</td></tr>";
}
function ShowNoteMsg($msg, $i=0)
{
	global $i;
	$usr = CheckUser();
	echo "<table style='width:100%;' cellspacing=1 id='t{$msg['mId']}'>";
	echo "<tr style='background:#".($i%2 ? "282828" : "333333")."' id='t{$msg['mId']}'>";
	echo "<td colspan='2' class='padding'><a name='id{$msg['mId']}'><div style='font-size:9px;text-align:right;'>";
	echo "<a href='../forums/addflink.php?link={$msg['mId']}' target='actions' style='color:orange;text-decoration:none;' title='Add to fast panel'>+</a> &nbsp;";
	echo "<span style='color:grey;'>".sGetFDate($msg['mDate'])."</span> ";
	echo "<span style='font-weight:bold;color:magenta;'>{$msg['uNick']}</span>: &nbsp; ";
	if($msg['mUid']==$usr['uId'] || $usr['uId']==1) 
	{
		echo " <a href='../files/main.php?script=addmsg&eMsg={$msg['mId']}'>[Редагувати]</a> ";
		echo " <a target='actions' title='Видалити' onClick='DelRow(\"t{$msg['mId']}\", {$msg['mId']});'>[x]</a>"; 
	}
	echo "</div>".$msg['mMsg']."</td></tr>";
	echo "</table>";
}
function GetLastMsgId($fid='mFId')
{
	$query = "select mId from msgs where mFid=$fid order by mDate desc limit 1";
	$res = uquery($query);	
	if($res && mysql_num_rows($res)) return mysql_result($res,0,0);
	return 0;			
}
function GetLastMsgPid()
{
	$query = "select mPmsg from msgs order by mDate desc limit 1";
	$res = uquery($query);	
	if($res && mysql_num_rows($res)) return mysql_result($res,0,0);
	return 0;			
}
function GetLastMsg()
{
	$query = "select * from msgs order by mDate desc limit 1";
	$res = uquery($query);	
	if($res && mysql_num_rows($res)) return mysql_fetch_array($res);
	return 0;			
}
function GetLastMsgs($limit = 8, $skip = 0)
{
	global $user;
	$query = "select *, to_days(mDate) as mDays from msgs,forums,users 
				where mUid=uId and mFid=fId and mType<127 and {$user['uLevel']}>=mLevel 
				and not(mFid=61 AND mUid<>{$user['uId']})
				order by mDate desc limit $skip, $limit";
	$res = uquery($query);
	for($result=array(); $msg=mysql_fetch_array($res); )
	{
		$msg['Date'] = ConvertDate($msg['mDate']);
		$result[]=$msg;
	}
	if($res && mysql_num_rows($res)) return $result;
	return 0;			
}

function GetLastParentMsgs($limit = 8, $skip = 0)
{
	global $user;
	$query = "select * from msgs,forums,users 
				where mUid=uId and mFid=fId and mType<127 and {$user['uLevel']}>=mLevel 
				and not(mFid=61 AND mUid<>{$user['uId']})
				and mPmsg = 0 
				order by mDate desc limit $skip, $limit";

	$res = uquery($query);
	for($result=array(); $msg=mysql_fetch_array($res); )
	{
		$msg['Date'] = ConvertDate($msg['mDate']);
		$result[]=$msg;
	}
	if($res && mysql_num_rows($res)) return $result;
	return 0;			
}

function DEBUG($text)
{
	echo "<scipt>alert('$text');</script>";
}
function LastAnswerId($mid)
{
	$query = "select mid from msgs where mpmsg=$mid order by mDate desc limit 1";
	$res = uquery($query);	
	if($res && mysql_num_rows($res)) return mysql_result($res,0,0);
	return 0;
}

function GetNewMsgs()
{
	global $user;
	$query = "select mId from msgs where mDate >= (SELECT uLastDate FROM users WHERE uId={$user['uId']}) 
				and mType<127 and {$user['uLevel']}>=mLevel order by mDate desc";

	$res = uquery($query);
	$result=array(); 
	
	if( $res && mysql_num_rows($res) )
		for(; $row=mysql_fetch_array($res); $result[$row['mId']]=$row['mId']);

	return $result;
}
function UpdateMsgCount($mId)
{
	$query = "update msgs set mCount=mCount+1 where mId=$mId";
	return uquery($query);
}
///////////////////////////////////////////////////////////////////////////////////////
//
// LOG functions
//
////////////////////////////////////////////////////////////////////////////////////////
function GetLogMsgs($where="", $limit=10, $skip=0)
{
	$query = "SELECT *,max(logId) max_id, max(logTime) time FROM log, users WHERE logUid=uId $where GROUP BY logMsg ORDER BY max_id DESC LIMIT $skip, $limit";
	$res = uquery($query);
	for($result=array(); $row=mysql_fetch_array($res); $result[$row['max_id']]=$row);
	krsort($result);
	return $result;
}
function GetFullLogMsgs($where="", $limit=10, $skip=0)
{
	$query = "SELECT *,logTime as time FROM log, users WHERE logUid=uId $where ORDER BY logId DESC LIMIT $skip, $limit";
	$res = uquery($query);
	for($result=array(); $row=mysql_fetch_array($res); $result[]=$row);
	return $result;
}
function GetLogDesc($type)
{
	switch($type)
	{
	case 1: return "<span style='color:yellow'>увійшов з </span'>";
	case 2: return "<span style='color:grey'>вийшов </span'>";
	case 3: return "<span style='color:red'>додав </span>";
	case 4: return "невірний пароль ";
	case 5: return "<span style='color:orange'>відредагував</span> ";
	case 6: return "<span style='color:green'>автовхід з </span>";
	case 101: return "переглянув ";
	case 105: return "<b style='color:red'>видалив </b>";
	case 106: return "завантажив ";
	case 107: return "<span style='color:magenta'>шукав </span>";
	case 108: return "змінив особисті дані ";
	case 109: return "Чат: ";
	default: return "unknown operation";
	}
}
function ShowLogs($msg)
{
	global $user;
	$d = explode("|",$msg['logMsg']);
	if(count($d) == 0) return;
	$ip = long2ip(hexdec($d[0]));
	$ip = "<a href='../files/main.php?script=geoip&ip=$ip'>$ip</a>";
	$m = GetLogDesc($msg['logType']);
	switch($msg['logType'])
	{
	case 6: // the same as 1
	case 1: $m .= $ip; break;
	case 2: $m .= "( $ip )"; break;
	case 3: 
	case 5:
	case 101:
	
			$p = GetPageById($d[1]); if(!$p) break;
			$mess = GetMsg($d[2]); if(!$mess) break;
			if($mess['mPmsg']>0) $mess = GetMsg($mess['mPmsg']); if(!$mess) break;
			if(defined("_LOG_")) $len = strlen($mess['mTheme']); else $len = 20;
			$m .= "<a href=main.php?script=showmsg&mid={$d[2]}>".substr($mess['mTheme'],0,$len)."..<a/>"; 
			if(defined("_LOG_")) $m .= " | ".$ip. " [{$msg['logId']}]";
			break;
	case 4: if($user['uId'] <= 2) $m .= "<span title='$ip'>( {$d[1]} )</span>"; break;
	case 105: 
			if(defined("_LOG_")) $len = strlen($d[1]); else $len = 20;
	$m .= "<b>".substr($d[1],0,$len)."..</b>"; break;
	case 106: 
			$f = GetBook($d[2]); if(!$f) break;
			$m .= "<a href='/plugins/books/download.php?bid={$f['bookId']}' style='color:#0080BF;'>".basename($f['bookPath'])."</a>"; break;
	case 107: $m .= "<b>{$d[1]}</b>"; break;
	case 109: $m .= "{$d[1]}"; break;
	}
	echo "<tr><td style='width:60px;color:gray;'>".sGetFDate($msg['time'])."</td>";
	echo "<td style='width:70px;text-align:center;'>".alink($msg).": &nbsp;</td><td>$m</td></tr>";
}
function AddLogMsg($uid, $msg, $type)
{
	global $REMOTE_ADDR;
	$msg = dechex(ip2long($REMOTE_ADDR))."|".$msg."|".$type."|".$uid;
	$query = "INSERT INTO log (logUid, logTime, logMsg, logType) VALUES($uid,NOW(),'$msg', $type)";
	return uquery($query);
}
function ClearLog()
{
	return uquery("DELETE FROM log");
}
function GetLogCount()
{
	$query = "SELECT count(*)  FROM  log";
	$res = uquery($query);	
	if($res && mysql_num_rows($res)) return mysql_result($res,0,0);
	return 0;
}
function GetThemeCount($pfid)
{
	$query = "select count(*) from msgs where mFid in (select fid from forums where fPid=$pfid) and mPmsg=0";
	$res = uquery($query);	
	if($res && mysql_num_rows($res)) return mysql_result($res,0,0);
	return 0;
}
function GetMessageCount($pfid)
{
	$query = "select count(*) from msgs where mFid in (select fid from forums where fPid=$pfid)";
	$res = uquery($query);	
	if($res && mysql_num_rows($res)) return mysql_result($res,0,0);
	return 0;
}
function PrepareMonth($date)
{
	$m = trim(substr($date,0,2));
	switch($m)
	{
	case 1: $mon = "Січ"; break;
	case 2: $mon = "Лют"; break;
	case 3: $mon = "Бер"; break;
	case 4: $mon = "Кві"; break;
	case 5: $mon = "Тра"; break;
	case 6: $mon = "Чер"; break;
	case 7: $mon = "Лип"; break;
	case 8: $mon = "Сер"; break;
	case 9: $mon = "Вер"; break;
	case 10: $mon = "Жов"; break;
	case 11: $mon = "Лис"; break;
	default: $mon = "Гру";
	}
	$date = substr($date, strpos($date, ' ')+1);
	$date = str_replace("_", $mon, $date);
	return $date;
}
function GetTheme($mid)
{
	$query = "SELECT mTheme FROM msgs WHERE mId=$mid";
	$res = uquery($query);	
	if($res && mysql_num_rows($res)) return mysql_result($res,0,0);
	return 0;
}
function GetLastMessage($pfid)
{
	global $user;
	$query = "select mId, mDate, mTheme, mPmsg, uNick, uId from msgs,users where {$user['uLevel']}>=mLevel and mUid=uId and  mFid in (select fid from forums where fPid=$pfid) order by mDate desc limit 1";
	$res = uquery($query);	
	if($res && mysql_num_rows($res)) 
	{
		$res = mysql_fetch_array($res);
		$res['Date'] = ConvertDate($res['mDate']);
		if($res['mPmsg'] == 0) $res['mPmsg'] = $res['mId'];
		else $res['mTheme'] = GetTheme($res['mPmsg']);
		$res['mTheme'] = substr($res['mTheme'],0, 25)." ..";
		return $res;
	}
	return 0;	
}
function ALink($v)
{
	return "<a href='../files/main.php?script=userprof&uid={$v['uId']}' style='font-weight:bold;'>{$v['uNick']}</a>";
}
function GetUserMsgCount($uid)
{
	$query = "SELECT count(*) FROM msgs WHERE mUid=$uid";
	$res = uquery($query);	
	if($res && mysql_num_rows($res)) return mysql_result($res,0,0);
	return 0;
}
function ConvertDate($date)
{
	$date = str_replace(":", " ", $date);
	$date = str_replace("-", " ", $date);
	$d = explode(" ", $date);
	
	// 0-Y 1-m 2-d 3-H 4-m 5-s
	switch($d[1])
	{
	case 1: $mon = "Січ"; break;
	case 2: $mon = "Лют"; break;
	case 3: $mon = "Бер"; break;
	case 4: $mon = "Кві"; break;
	case 5: $mon = "Тра"; break;
	case 6: $mon = "Чер"; break;
	case 7: $mon = "Лип"; break;
	case 8: $mon = "Сер"; break;
	case 9: $mon = "Вер"; break;
	case 10: $mon = "Жов"; break;
	case 11: $mon = "Лис"; break;
	default: $mon = "Гру";
	}
	
	$date = "{$d[2]} $mon {$d[0]}, {$d[3]}:{$d[4]}:{$d[5]}";
	return $date;
}
function AddFastLink($name, $link, $uid)
{
	DelXSS($name); DelXSS($link);
	$query = "insert into fast_links values(NULL, '$name', '$link', $uid)";
	uquery($query);	
}
function GetFastLink($id)
{
	global $user;
	if(!$user) return 0;
	$query = "SELECT * FROM fast_links WHERE flId=$id AND flUid={$user['uId']}";
	$res = uquery($query);	
	if($res && mysql_num_rows($res)) return mysql_fetch_assoc($res);
	return 0;
}
function GetFastLinks()
{
	global $user;
	if(!$user) return 0;
	$query = "SELECT * FROM fast_links WHERE flUid={$user['uId']}";
	$res = uquery($query);
	$result=array();
	for(; $row=mysql_fetch_assoc($res); $result[]=$row);
	if(count($result)) return $result;
	return 0;
}
function DelFastLink($id)
{
	global $user;
	if(!$user) return 0;
	$query = "DELETE FROM fast_links WHERE flId=$id AND flUid={$user['uId']}";
	return uquery($query);
}
function GetAvatarHTML($size=0)
{
	global $user;
	return "<img $attr src='../img/avatars/".GetUserAvatar($user['uId'])."'>";
}

function GetLastAnswer($mid)
{
	$sql = "SELECT * FROM msgs,users WHERE (mId=$mid OR mPmsg=$mid) AND mUid=uId ORDER BY mId DESC LIMIT 1";
	$res = uquery($sql);	
	if($res && mysql_num_rows($res)) 
	{
		$msg = mysql_fetch_array($res);
		$msg['Date'] = ConvertDate($msg['mDate']);
		if($msg['mLevel'] > $user['uLevel']) $msg['mMsg'] = "<br><div class='rc'>Для перегляду повідомлення потрібно мати level ".$msg['mLevel']."</div>";
		return $msg;
	}
	return 0;	
}
function GetUserKarma($uid)
{
	$sql = "SELECT sum(krmMark) FROM karma WHERE krmUid=$uid";
	$res = uquery($sql);
	if($res && mysql_num_rows($res)) return mysql_result($res, 0, 0);
	return 0;
}
function GetMsgKarma($mid)
{
	$sql = "SELECT sum(krmMark) FROM karma WHERE krmMid=$mid";
	$res = uquery($sql);
	if($res && mysql_num_rows($res)) return mysql_result($res, 0, 0);
	return 0;
}
function ConvertBytes($bytes)
{
	if($bytes > 1000000)
	{
		return (round($bytes / 10000) / 100)." Mb";
	}
	else if($bytes > 1000)
	{
		return (round($bytes / 10) / 100)." Kb";
	}
	else return $bytes." b";
}

function GetAttachedFiles($mid)
{
	$sql = "SELECT fileId, fileName, length(fileCont) as fileLength FROM attached_files, files WHERE afMid=$mid AND fileId=afFid";
	$res = uquery($sql);
	$result = array();
	for(; $row=mysql_fetch_array($res); $result[]=$row);
	if( count($result) ) return $result;
	return 0;
}

function ChangeMsgForum($mid, $fid)
{
	$sql = "UPDATE msgs SET mFid=$fid WHERE mId=$mid OR mPmsg=$mid";
	return uquery($sql);
}

function GetChildForums()
{
	$sql = "SELECT * FROM forums WHERE fPid IN (SELECT fId FROM forums WHERE fPid IN (SELECT fId FROM forums WHERE fPid = 0))";
	$res = uquery($sql); $result = array();
	for( ; $row = mysql_fetch_array($res); $result[] = $row);
	if( count($result) ) return $result;
	return 0;
}

// user uploaded files
function GetUserUploadFiles( $uid )
{
	$sql = "SELECT * FROM files WHERE fileUid = $uid";
	$res = uquery( $sql );
	$result = array();
	for( ; $row = mysql_fetch_array($res); $result[] = $row);
	if( count($result) ) return $result;
	return 0;
}

// for message
function GetAttacFilesList( $mid )
{
	$sql = "SELECT afId, afMid, afFid, fileName FROM attached_files, files WHERE fileId=afFid AND afMid=$mid";
	$res = uquery($sql);
	$res = uquery( $sql );
	$result = array();
	for( ; $row = mysql_fetch_array($res); $result[] = $row);
	if( count($result) ) return $result;
	return 0;	
}

function AttachFile($mid, $fid)
{
	$sql = "INSERT INTO attached_files VALUES(NULL, $mid, $fid)";
	return uquery($sql);	
}

function DeleteAttachedFile($did)
{
	$sql = "DELETE FROM attached_files WHERE afId=$did";
	return uquery($sql);
}

function AddLike( $mid, $uid, $type )
{
	$sql = "INSERT INTO likes VALUES( $mid, $uid, '$type' )";
	return uquery( $sql );
}

function DelLike( $mid, $uid, $type )
{
	$sql = "DELETE FROM likes WHERE likeMid=$mid AND likeUid=$uid AND likeType='$type' LIMIT 1";
	return uquery( $sql );
}

function LikeExists( $mid, $uid, $type )
{
	$sql = "SELECT * FROM likes WHERE likeMid=$mid AND likeUid=$uid AND likeType='$type' LIMIT 1";
	$res = uquery( $sql );
	return ( $res && mysql_num_rows($res) );
}

function SmartAddLike( $mid, $uid, $type )
{
	if( LikeExists($mid, $uid, $type) ) DelLike($mid, $uid, $type);
	else AddLike($mid, $uid, $type);
	DelLike( $mid, $uid, $type=='l' ? 'd' : 'l' );
}

function GetLikesCount( $mid, $type )
{
	$sql = "SELECT count(1) FROM likes WHERE likeMid=$mid AND likeType='$type'";
	$res = uquery( $sql );
	if( $res && mysql_num_rows($res) ) return mysql_result( $res, 0, 0 );
	else return 0;
}

function MakeTDLink($text)
{
    return "<div style='height:100%;width:100%'>$text</div>";
}
?>
