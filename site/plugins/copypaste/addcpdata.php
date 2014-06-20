<?
	include_once "../files/common.php";
	include_once "../users/users.php";
	include_once "copypaste.php";
	$user = CheckUser(); if( !$user ) die();
	
	if( isset($_POST['cpdata']) )
	{
		$data = $_POST['cpdata'];
		AddCPData( $user['uId'], $data );
	}
	
	if( isset($_GET['del']) )
	{
		$del = (int)$_GET['del'];
		if( $del )
		{
			DelCPData( $user['uId'], $del );
		}
	}
	
?>

<br><br><center>
<div class='frmframe' style='width:800px;'><table class='frmlist' style='background:#313131;' cellspacing='1'>

	<form action='' method=post actions='actions' id='cp_form'>
		<tr class='frmttl'><td class='padding' style='text-align:center;font-weight:bold;' colspan='2'>Add new CopyPaste</td></tr>
		<tr><td class='' style='text-align:center;'>
			<textarea name='cpdata' rows='2' style='background:black;color:white;width:100%;' id='cpdata'></textarea>
		</td>
		<td style='text-align:right;width:80px;' class='padding'>
			<input type='submit' value='Add Data' name='AddCPData'>
		</td></tr>
	</form>

<?
	$list = GetLastCPDatas( $user['uId'] );	

	$i = 0;
	if($list) foreach($list as $v)
	{
		$border_start = "<div id='sel$i' onclick='selectText(\"sel$i\")' style='color:#99FF99;padding:10px;border:solid 1px black;white-space: pre;background:#".(++$i%2 ? "282828" : "333333")."'>";
		$border_end = "</div>";
	
		echo "<tr><td colspan=2 class='padding' style='background:#".(++$i%2 ? "282828" : "333333")."'>";
		echo "<span style='color:magenta;background:black;font-size:10px;float:right;'>{$v['cpDate']} &nbsp;";
		echo "<a title='Delete' href='/files/main.php?script=addcpdata&del={$v['cpId']}' style='color:red;'>[x]</a></span>";
		echo $border_start.stripslashes($v['cpMsg']).$border_end."</td></tr>";
	}
	else
		echo "<tr><td colspan=2 class='padding' style='background:#282828;text-align:center;color:red;'>
			{$border_start}There are no records here{$border_end}</td></tr>";
?>
</table></div>

<script>

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
	
	var el = document.getElementById('cpdata');
	el.focus();
	
	$('#cpdata').keydown(function(key)
	{
		if( key.keyCode == 13 )
		{
			$('#cp_form').submit();
		}
	});

</script>