<?
	include_once "functs.php";
	
	$searchStr = "";
	if( isset($_POST['searchcmp']) ) //$searchStr = $_POST[ 'searchcmp' ];
		$searchStr = mb_convert_encoding($_POST[ 'searchcmp' ], "windows-1251", "utf-8");

	echo "<div class='frmframe'><table class='frmlist' cellspacing='1'>";
	$clist = GetTransDetails( $searchStr );
	if($clist) foreach( $clist as $c )
	{
		echo "<tr>
				<td class='frmcontc'>{$c['trName']}</td>
				<td class='frmcontc'>{$c['trAnalogue']}</td>
				<td class='frmcontc'>{$c['trReplacement']}</td>
			</tr>";
	}
	else echo "<tr><td class='frmcontc' colspan='3' style='color:Red;'>No Results</td></tr>";
	echo "</table></div>";
?>