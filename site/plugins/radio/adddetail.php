<?
	if( !defined('PLUGIN_PATH') || !isset($catId) ) die();
	
	$bEditMode = false;
	$visibility = "visibility:hidden;height:0px;";
	if( isset($_GET['editId']) && (int)$_GET['editId'] )
	{
		$editId = (int)$_GET[ 'editId' ];
		$item = GetItem( $editId );
		if( $item) {
			// var_dump( $item );
			$bEditMode = true;
			$visibility = "";
		}
	}

	echo "<a id='showadddetail' href='javascript:void()'>Add Detail Dialogue</a>
		<center>
		<div id='adddetail' style='$visibility'>
		<div class='frmframe' style='width:460px;'><table class='frmlist' cellspacing='1'>
			<form action='' method='post'>
			<tr class='frmttl'>
				<td class='frmttl' colspan='5'>".( $bEditMode ? "Edit Detail" : "Add Detail")."</td>
			</tr>
			<tr class='profkey'>
				<td class='profkey'>Name </td>
				<td class='profkey'>
					<input type='text' name='item' style='width:236px;' value='".($bEditMode ? $item['itName'] : "")."'>
				</td>
				<td class='profkey'>Count </td>
				<td class='profkey'>
					<input type='text' name='count' style='width:40px;' value='".($bEditMode ? $item['itCount'] : "")."'>
				</td>
				<td class='profkey'>
					<input type='submit' value='".($bEditMode ? "Save" : "Add")."'>
				</td>
			</tr>
			<tr>
				<td class='profkey' colspan='6'>Description 
					<textarea name='desc' style='height:120px;'>".($bEditMode ? $item['itDesc'] : "")."</textarea>
				</td>
			</tr>
			<input type='hidden' name='catId' value='$catId'>
			".($bEditMode ? "<input type='hidden' name='id' value='$editId'>" : "")."
			</form>
		</table></div>
		</div>";
	echo "</center>";
?>
<script>
$(document).ready(function()
{
	$('#showadddetail').click(function()
	{
		$visibility = $('#adddetail').css("visibility");
		if( $visibility == 'hidden' ) 
		{
			$('#adddetail').css( "visibility", 'visible' );
			$('#adddetail').height(200);
		}
		else
		{
			$('#adddetail').css( "visibility", 'hidden' );
			$('#adddetail').height(0);
		}
	});
});
</script>
