<?
	if( !defined('PLUGIN_PATH') || !isset($detId) ) die();

	include_once BASE_PATH."/files/common.php";
	include_once BASE_PATH."/users/users.php";

	if( !($user=CheckUser()) ) EchoErrorMsg("","../../users/enter.php");
?>

 &nbsp; <a id='showaddfile' href='javascript:void();'>Add File Dialogue</a>
<center>
<div class='frmframe' style='width:380px;visibility:hidden;' id='addfile'><table class='frmlist' cellspacing='0'>
	<form method='post' action='../plugins/radio/upload.php' enctype='multipart/form-data' name='uploadfile' target='uploadframe'>
		<tr class='frmttl'><td colspan='2' class='paddingc'>Додати файл</td></tr>
		<!--
		<tr style='background:#282828;'>
			<td class='paddingc'>File name :</td>
			<td class='paddingc'><input type='text' name='filename' >
			<div style='font-size:9px;'>З таким іменем файл буде скачуватися</div></td>
		</tr>
		<tr style='background:#333333;'>
			<td class='paddingc'>File description :</td>
			<td class='paddingc'><input type='text' name='filedesc' ></td>
		</tr>
		-->
		<tr style='background:#282828;'>
			<td colspan='2' class='paddingc'><input type='file' name='file'> <input type='submit' value='Завантажити'></td>
		</tr>
		<input type='hidden' name='detId' value='<?=$detId;?>' >
	</form>
</td></tr>

</table></div>

<iframe name='uploadframe' frameborder="no" src='../files/blank.php'></iframe>
<script>
$(document).ready(function()
{
	$('#showaddfile').click(function()
	{
		$visibility = $('#addfile').css("visibility");
		if( $visibility == 'hidden' ) 
		{
			$('#addfile').css( "visibility", 'visible' );
			$('#addfile').height(74);
		}
		else
		{
			$('#addfile').css( "visibility", 'hidden' );
			$('#addfile').height(0);
		}
	});
});
</script>