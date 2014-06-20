<?
	include_once "../files/common.php";
	include_once "../users/users.php";	
	include_once "forums.php";	
	

	if(!($user=CheckUser())) EchoErrorMsg("","../users/enter.php");
	if(isset($_GET['mid'])) $_SESSION['mId'] = (int)$_GET['mid'];
	if(!isset($_SESSION['mId'])) die(); else $mId=$_SESSION['mId'];

	$msg = GetMsg($mId); if(!$msg) die();
	UpdateMsgCount($mId);
	$f = GetForum($msg['mFid']);
	$forumid = $f;

	$pf = $f;
	$fout = "";
	while($pf) 
	{
		$fout = "<a style='color:magenta;' class=path href='/files/main.php?script=showforum&fid={$pf['fId']}'>".$pf['fName']."/</a>".$fout;
		$pf = GetForum($pf['fPid']);
	}
	ShowPrompt( $fout );
	
	if(isset($_GET['mid'])) AddLogMsg($user['uId'], "{$page['pId']}|{$_SESSION['mId']}",101);
	
	if(!isset($_SESSION['fId'])) $_SESSION['fId'] = $msg['mFid'];
	echo "<a style='color:magenta;' class=path href=''>{$msg['mTheme']}/</a>";

?>
<link href="/forums/css/shCore.css" rel="stylesheet" type="text/css" />
<link href="/forums/css/shThemeFadeToGrey.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/forums/js/shCore.js"></script>
<script type="text/javascript" src="/forums/forum.js"></script>
<?
	foreach($langs as $lang) echo "<script type='text/javascript' src='/forums/js/shBrush$lang.js'></script>";

	$buttonpanel = "
	<table class='frmlist' cellspacing='1'>
	<tr><td class='cmdpanel'>";
	if(!$msg['mPmsg'] || ($msg['mFid']!=61 && $msg['mUId']==$user['uId']))
	{
		$buttonpanel .=	"<a href='../files/main.php?script=addmsg&mPmsg=$mId'>Відповідь</a> &nbsp;";
	}
	$buttonpanel .= "
		<a href='../files/main.php?script=addmsg&mPmsg=0'>Нова тема</a> &nbsp;</td></tr>
	</table>
	";
	echo $buttonpanel;
?>

	<div class='frmframe'><table class='frmlist' cellspacing='1'>
	<tr class='frmttl'>
	<td class='msgttl'><input type='hidden' value='<?=$mId;?>' id='message'>

	<table cellspacing='0' style='width:100%;'><tr>
		<td style='width:70px;vertical-align:middle;'>Пошук: </td>
		<td style='width:200px;'><input type='text' id='keyword' style='width:100%' value='<?=$_SESSION['n_keyword'];?>'></td>
		<form action='../forums/addmsg.php?mPmsg=<?=$msg['mId'];?>' method='post' target=''>
			<td style='width:140px;vertical-align:middle;'> &nbsp; Швидка відповідь: </td>
			<td><input type='text' name='mMsg' style='width:100%' value=''></td>	
			<input type='hidden' name='mTheme' value='<? echo "Re:".$msg['mTheme']; ?>'>
			<input type='hidden' name='level' value='<?=$msg['mLevel'];?>'>
			<input type='hidden' name='save' value='1'>
			<input type='hidden' name='edit' value='0'>
		</form>
		</tr>
	</table>

	
	</td></tr></table>
	
<?	echo "<div id='msgs' style='width:100%;'>";

	echo "<table class='frmlist' cellspacing='0' cellpadding='0' style='background:black;'>";
	
	$i = 0;
	if( $msg['mFid'] == 61 && $user['uId'] !== $msg['mUid'] ) die();	
	
	ShowMsg($msg);
	if($msg['mId']==1234 && $user['uLevel']>=$msg['mLevel'])
	{
		include_once "showpass.php";
	}
	
	$sm = GetSubMsgs($mId);
	if($sm) foreach($sm as $v) 
	{
		$v['mTheme'] = "Re: {$msg['mTheme']}";
		ShowMsg($v);
	}

	echo "</table>";

	echo "</div></div><br>";
	echo $buttonpanel;
	echo "<div id='result'></div>";
	
?>
<script type="text/javascript">
SyntaxHighlighter.config.bloggerMode = true;
SyntaxHighlighter.config.clipboardSwf = '../forums/js/clipboard.swf';
SyntaxHighlighter.all();

function SH(id) 
{
	if (document.getElementById(id).style.display == "none")
	{
		document.getElementById(id).style.display = "block"
		document.getElementById(id-1).innerHTML = "[-] Hide ";
	}
	else
	{
		document.getElementById(id).style.display = "none"
		document.getElementById(id-1).innerHTML = "[+] View ";
	}
}

function selectText(containerid) {
	if (document.selection) {
		var range = document.body.createTextRange();
		range.moveToElementText(document.getElementById(containerid));
		range.select();
	} else if (window.getSelection) {
		var range = document.createRange();
		range.selectNode(document.getElementById(containerid));
		window.getSelection().addRange(range);
	}
}

</script>
<script src='../forums/js/jquery.js'></script>
<script>
function AddLink(id)
{
	alert('Закладку додано');
	load('../forums/addflink.php?link='+id, 'fastlinks');
}
$(document).ready(function()
{
	$('#keyword').keyup(function()
	{
		$.ajax({
			type: "POST",
			url: "../forums/getmsgs.php",
			data: "&keyword="+$("#keyword").val() + "&mid="+$("#message").val(),
			success: function(html) 
			{
				$("#msgs").html( html );
			}
		});

		return true;
	});
	
	$('#forum').change(function()
	{
		document.location.href.reload();
	});
	
	$( "span" ).each( function( index ) { 
		idString = $(this).attr("id");
		if( idString.substr(0, 8) == 'likeCont' )
		{
			mId = idString.substr( 8 );
			$('#likeCont'+mId).load( '../forums/like.php?mid=' + mId );
		}
	});
});


function DelRow(rowId, msgId)
{
	$('#'+rowId).load('../forums/del.php?dId='+msgId);
}

function Like( id )
{
	$('#likeCont'+id).load( '../forums/like.php?like=' + id );
}
function DisLike( id )
{
	$('#likeCont'+id).load( '../forums/like.php?dislike=' + id );
}

</script>
