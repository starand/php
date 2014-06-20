<?
	include_once "../forums/forums.php";
####################################################
#					Search functions
##	search query in db into FORUMS
function ForumSearch($text, $uid=0, $skip=0, $limit=0) 
{
	if($uid==0) $uid='muid';
	if(defined("_SIMPE_FIND_")) 
		$query = "select uId,mMsg,mId,mDate,uNick,mPmsg,fType,mLevel from msgs,users,forums where fId=mFid and mUid=$uid and uid=mUid and mPmsg!=155 and (mMsg like '%$text%' OR mTheme like '%$text%') order by mId desc".(($skip || $limit) ? " limit $skip, $limit" : "");
	else 
		$query = "select uId,mMsg,mId,mDate,uNick,mPmsg,fType,mLevel from msgs,users,forums where fId=mFid and mUid=$uid and uid=mUid and mPmsg!=155 and match(mMsg) against('$text') order by mId desc".(($skip || $limit) ? " limit $skip, $limit" : "");	

	$res = uquery($query); 
	for($result=array();$row=mysql_fetch_array($res);$result[]=$row);
	if($res && mysql_num_rows($res)) return $result; return 0;
}
## return link for see search result
function GetSearchLink($msg)
{
	if($msg['mPmsg']) $mid = $msg['mPmsg']; else $mid=$msg['mId'];
	switch($msg['fType'])
	{
		case 0: $link = "/files/main.php?script=showmsg&mid=$mid#id{$msg['mId']}"; break;
		case 1: $link = "/files/main.php?script=showart&artid=$mid#id{$msg['mId']}"; break;
		default: $link = "/files/main.php";
	}
	return $link;
}
## out to browser one result
function OutResult($item, $fstr, $link,$num) 
{
	global $i;
	$i++;
	
	$user = CheckUser();
	$fstr = str_replace("*","\*",$fstr);
	if($item['mLevel'] > $user['uLevel']) $text = "<br><div class='rc'>Для перегляду повідомлення потрібно мати level ".$msg['mLevel']."</div>";
	else 
	{
		$text = str_replace("<br//>", " ", $item['mMsg']);
		$text = strip_tags($text);
		$start = strpos(strtolower($text),strtolower($fstr));
		if($start>150) $start = $start-150; else $start = 0;
		$text = preg_replace("|$fstr|i","<b class=light>$0</b>",$text);
		$text = substr($text,$start,300+strlen($fstr));
		if($item['mPmsg'] == 0) $item['mPmsg'] = $item['mId'];
	}
	$pm = GetMsg($item['mPmsg']);
	echo "<tr style='background:#".($i%2 ? "282828" : "333333")."'>
		<td class='profvalue' style='background:inherit;'>
		<div class='bsmall'><a href='../files/main.php?script=showmsg&mid={$pm['mId']}'>{$pm['mTheme']}</a></div>
		<a href='".GetSearchLink($item)."'>... $text ...</a></td>
		<td class='profavatar' style='background:inherit;'>".alink($item)."</td>
		<td class='srchdate' style='background:inherit;'>".ConvertDate($item['mDate'])."</td></tr>";
};

?>