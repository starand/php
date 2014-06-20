<?
	if( !defined('PLUGIN_PATH') ) die();
	
	echo "<a id='showcomptibility' href='javascript:void()'>Compatibility</a>";
	
	echo "<center><div id='compframe' style='visibility:hidden;height:0px;width:400px;'>";
	
	echo "<div class='frmframe'>";
		echo "<table class='frmlist' cellspacing='1'>
				<tr class='frmttl'>
					<td class='frmcontc' colspan='3'>
						<input type='text' name='search_comp' style='width:100%;' id='searchcmp'>
					</td>
				</tr>
			</table>
		</div>";
		
	echo "<div id='compatibility'>Loading ..</div>";
		
	echo "</div></center>";
?>
<script>
$(document).ready(function()
{
	$("#compatibility").load( "/plugins/radio/compatibility.php" );

	$('#showcomptibility').click(function()
	{
		$visibility = $('#compframe').css("visibility");
		if( $visibility == 'hidden' ) 
		{
			$('#compframe').css( "visibility", 'visible' );
			$('#compframe').height(1000);
		}
		else
		{
			$('#compframe').css( "visibility", 'hidden' );
			$('#compframe').height(0);
		}
	});
});

$(document).ready(function()
{
	$('#searchcmp').keyup(function()
	{
		$.ajax({
			type: "POST",
			url: "/plugins/radio/compatibility.php",
			data: "&searchcmp="+$("#searchcmp").val(),
			success: function(html) 
			{
				$('#compatibility').html(html);
				$('#compatibility').css( "visibility", 'visible' );
				$('#compatibility').height(1000);
			}
		});

		return true;
	});
});
</script>