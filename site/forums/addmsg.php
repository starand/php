<?
	include_once "../files/common.php";
	include_once "../users/users.php";
	include_once "forums.php";
	include_once "highlight.php";
	
	if(!($user=CheckUser())) EchoErrorMsg("","../users/enter.php");
	if(isset($_GET['fid'])) $_SESSION['fId'] = (int)$_GET['fid'];
	if(!isset($_SESSION['fId'])) die("Dont found FID"); else $fId=$_SESSION['fId'];
	
	
	if(isset($_GET['msg'])) echo "<h1>".$_GET['msg']."</h1>";
	
	if(isset($_GET['mPmsg']) && $_GET['mPmsg'] != 0)
	{
		$pMsg = (int)$_GET['mPmsg'];
		$pm = GetMsg($pMsg);
		if(!$pm) die('Invalid parent');
		$fId=$_SESSION['fId'] = $pm['mFid'];
		$_SESSION['pMsg'] = $pMsg;
	}
	else $pMsg = 0;
	
	if(isset($_GET['eMsg'])) $emsg = GetMsg((int)$_GET['eMsg']);
	if(isset($emsg) && $emsg['mUid'] != $user['uId'] && $user['uId'] != 1) EchoErrorMsg("Access denied!", "../files/main.php");

	$f = GetForum($fId); if(!$f) die("Invalid forum");	
		
	if(isset($_POST['exit'])) { $_SESSION['script'] = "showmsg"; EchoErrorMsg(); }
	
	if(isset($_POST['save']) && isset($_POST['mTheme']) && isset($_POST['mMsg']) && isset($_POST['edit']) && isset($_POST['level']))
	{
		$level = (int)$_POST['level']; 
		$mTheme = DelXSS( $_POST['mTheme'] );
		//if($mTheme === "") $mTheme == "No theme";
		$mMsg = $_POST['mMsg'];
		$msg = PrepareMsg($mMsg);
		$edit = GetMsg((int)$_POST['edit']);
		if($edit) 
		{
			EditMsg($edit['mId'],$msg,$mMsg, $level, ($edit['mPmsg']>0 ? "" : $mTheme));
			if($edit['mPmsg']>0) $lpid = $edit['mPmsg']; # last message parrent id
			else $lpid = $edit['mId'];
			$lmid = $edit['mId'];
			$pMsg = $lpid;
			AddLogMsg($user['uId'], "11|$lmid",5);
		}
		else
		{
			AddMsg($user['uId'],$fId,$pMsg,($pMsg) ? "": $mTheme,$msg,$REMOTE_ADDR, $mMsg, $level);
			$lm = GetLastMsg(); 	$lmid = $lm['mId'];		$lpid = $lm['mPmsg'];
			if($lpid == 0) $lpid = $lmid;
			AddLogMsg($user['uId'], "11|$lmid",3);
			AddJarvisMessage( "New message from {$user['uNick']} at ".date("Y-m-d H:i:s").( strlen($mTheme) ? "\n( $mTheme )" : "") );
		}
		$_SESSION['script'] = "showmsg"; 
		$_SESSION['mId'] = $lpid;
		
		EchoErrorMsg("","../files/main.php?script=showmsg&mid=".(($pMsg) ? $pMsg : $lmid)."#id$lmid");
	}

	if(!isset($_SESSION['fId'])) die(); else $fId=$_SESSION['fId'];
	echo " to ";
	$pf = $f = GetForum($fId); if(!$f) die();
	$fout = "";
	while($pf) 
	{
		$fout = "<a style='color:magenta;' class=path href='/files/main.php?script=".$_SESSION['script']."'>".$pf['fName']."/</a>".$fout;
		$pf = GetForum($pf['fPid']);
	}
	echo $fout;
	
?>
<script language='JavaScript' src='../forums/forum.js'></script>
<center>
<!-- NEW MESSAGE DIALOG -->
<div class='frmframe'><table class='frmlist' cellspacing='1'>
<tr class='frmttl'><td class='frmttl'>���� ����</td><tr>
<tr><td style='background:#282828;'>

<table style='font-size:14px; font-weight:bold;height:70%;width:100%;'>
<form action='' method=post name='send' onSubmit='return Prepare(this);'>
<tr style="height:24px;"><td colspan=2>����: 
<?
	$etheme = "";
	if(isset($emsg))
	{
		if($emsg['mPmsg'])
		{
			$epm = GetMsg($emsg['mPmsg']);
			if($epm)
			{
				$etheme = "Re: ".$epm['mTheme'];
			}
		}
		else $etheme = $emsg['mTheme'];
	}
?>
<input type=text name=mTheme value='<?=(($pMsg) ? "Re:{$pm['mTheme']}" : "")?><?=$etheme;?>' style='width:800px;color:white;'></td></tr>
<tr style="height:20px;"><td colspan='2'><? ShowButtons(); ?></td></tr>
<tr style="height:20px;"><td colspan='2'>
<input type="text" readonly="readonly" id="helpbox" style="width:100%" class="helpline" value="��� �������� ������ ��������/����������� ������ ����� � �������� ������ ������������!" />
</td></tr>
<?
	$msg_cont = "";
	if(isset($_GET['qid']))
	{
		$qmsg = GetMsg((int)$_GET['qid']);
		if($qmsg) $msg_cont = "[quote]".$qmsg['mOrigMsg']."[/quote]";
	}
	if(isset($emsg) && $emsg) $msg_cont = $emsg['mOrigMsg'];
?>
<tr><td colspan=2><textarea name='mMsg' id='message' cols='120' style='background:black;color:white; width: 100%;height: 500px;'><?=$msg_cont;?></textarea></td></tr>
<tr style='height:24px;'><td style='vertical-align:middle;'>Nick: <input type=text readonly value='<?=$user['uNick'];?>'>
<?
	if(isset($emsg) && $emsg) $lev = $emsg['mLevel']; 
	elseif($pMsg) $lev = $pm['mLevel'];
	else $lev = 0;
	
	echo "&nbsp; Level: <input type=".($user['uLevel'] ? "text" : "hidden" )." name='level' value='$lev' style='width:40px;'>";

	// attached files
	if( isset($emsg) && (int)$emsg['mId'] )
	{
		$existMgs = (int)$emsg['mId'];
		echo "<span id='attachedlist'></span>";
		echo "<script>$(\"#attachedlist\").load('/forums/getattachedlist.php?mid='+$existMgs);</script>";
		echo "&nbsp; <a class='link' id='load_af' onClick='LoadFileList($existMgs)'>Attach</a> &nbsp;";	
		echo "<span id='loaddiv'></span>";
	}
	?>
	

</td>
	<td align=right> <input type=submit name='save' value='<?=((isset($emsg) && $emsg)  ? "Change" : "Add msg")?>'>

<?	
	$link = "main";
	if( isset($emsg) && $emsg ) $link = "showmsg&mid={$emsg['mId']}";
?>
	<input type='button' name='exit' value='Cancel' onClick="document.location.href='../files/main.php?script=<?=$link ;?>';">
	<input type='hidden' name='edit' value='<?=((isset($emsg) && $emsg) ? "{$emsg['mId']}" : "0")?>' >
</td></tr>

</form>
</table>


</td></tr>
</table></div>

<script>
function Prepare(form)
{
	var theme = form.mTheme.value;
	if(theme.length == 0)
	{
		alert("������ ���� �����������!");
		return false;
	}
	return true;
}

function helpline(text)
{
	var hl = document.getElementById('helpbox');
	switch(text) 
	{
	case 'b': hl.value = "������"; break;
	case 'i': hl.value = "�����"; break;
	case 'con': hl.value = "���������� �����"; break;
	case 'c': hl.value = "���"; break;
	case 'li': hl.value = "������� ������"; break;
	case 'a': hl.value = "ó������������"; break;
	case 'img': hl.value = "����������"; break;
	case 'br': hl.value = "����� �����"; break;
	case 'hr': hl.value = "������������� ���"; break;	
	case 'h1': hl.value = "���������. ������� ���������: h1-h4"; break;	
	case 'table': hl.value = "�������. ������� ����: table, tr, th, td"; break;	
	case 'center': hl.value = "³����������� �����"; break;	
	case 'left': hl.value = "�������� �� ����� ����"; break;
	case 'right': hl.value = "�������� �� ������� ����"; break;
	case 'justify': hl.value = "�������� �� ���� �����"; break;		

	case 'asm': hl.value = "��� �� ����� Assambler"; break;
	case 'delphi': hl.value = "��� �� ��� Delphi"; break;		
	case 'cpp': hl.value = "��� �� ����� �/�++"; break;
	case 'bash': hl.value = "shell ������"; break;		
	case 'perl': hl.value = "��� �� ��� perl"; break;		
	case 'php': hl.value = "��� �� ��� ���"; break;		
	case 'python': hl.value = "��� �� ��� �ython"; break;		
	case 'sql': hl.value = "��� �� ��� SQL"; break;

	case 'rc': hl.value = "������� �������� ��������"; break;
	case 'gc': hl.value = "������� ������� ��������"; break;
	case 'yc': hl.value = "������� ������ ��������"; break;
	case 'oc': hl.value = "������� ��������� ��������"; break;
	case 'mc': hl.value = "������� ���������� ��������"; break;
	
	case 'video': hl.value = "�������� ����"; break;
	case 'h': hl.value = "������� �����"; break;
	
	
	
	default: hl.value = "��� �������� ������ ��������/����������� ������ ����� � �������� ������ ������������!";
	}
}

function AttachFile(mid, fid)
{
	$("#attachedlist").load('/forums/getattachedlist.php?mid='+mid+'&fid='+fid);
}

function LoadFileList(mid)
{
	$('#loaddiv').load('/forums/userfilelist.php?mid='+mid);
}

function DeleteAttachFile( mid, did )
{
	$("#attachedlist").load('/forums/getattachedlist.php?mid='+mid+'&did='+did);
}

</script>
