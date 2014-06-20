<?
	if( !defined('PLUGIN_PATH') || !isset($catId) ) die();

	echo "<div class='frmframe'>";
		echo "<table class='frmlist' cellspacing='1'>
				<tr class='frmttl'>
					<td class='frmcontc' colspan='3'>
						<input type='text' name='search_comp' style='width:100%;' id='searchstr'>
					</td>
				</tr>
			</table>
		</div>";
		
	echo "<div id='detaillist'>Loading ..</div>";
	
	echo "<br>";
	
	$loadParam = "";
	if( (int)$catId )
	{
		$loadParam = "&catId=".(int)$catId;
	
		$catId = (int)$catId;
		include_once "adddetail.php";
		if( $catId == 2 ) include_once "resistors.php";
		if( $catId == 4 ) include_once "transistors.php";
		IF( $catId == 9 ) include_once "condensators.php";
	}
?>
<script>
$(document).ready(function()
{
	$("#detaillist").load( "/plugins/radio/detaillist.php?<?=$loadParam;?>" );
});

$(document).ready(function()
{
	$('#searchstr').keyup(function()
	{
		$.ajax({
			type: "POST",
			url: "/plugins/radio/detaillist.php",
			data: "&searchstr="+$("#searchstr").val()+"<?=$loadParam;?>",
			success: function(html) 
			{
				$('#detaillist').html(html);
			}
		});

		return true;
	});
});
</script>