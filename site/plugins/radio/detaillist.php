<?
	include_once "functs.php";
	
	$searchStr = "";
	if( isset($_POST['searchstr']) ) //$searchStr = $_POST[ 'searchcmp' ];
		$searchStr = mb_convert_encoding( DelXSS($_POST[ 'searchstr' ]), "windows-1251", "utf-8");
		
	$catId = "itCatId";
	if( isset($_POST['catId']) ) $catId  = (int)$_POST['catId'];
	else if( isset($_GET['catId']) ) $catId  = (int)$_GET['catId'];
	$bCommonList = $catId === "itCatId";
	
	$itemList = GetItems( $catId, $searchStr );
	if( (int)$catId ) $cat = GetCategory( (int)$catId );
	
	echo "<div class='frmframe'><table class='frmlist' cellspacing='1'>";
	echo "<tr class='frmttl'>
			<td class='frmttlc' colspan='".($bCommonList ? 4 : 3)."'>
				Details ".(isset($cat) ? " : {$cat['catName']}" : "")."
			</td>
		</tr>";

	if( $itemList ) foreach( $itemList as $v )
	{
		echo "<tr class='frmcont'>
				<td class='frmcontc' style='width:200px;'>
					<a href='/files/main.php?script=radio&detId={$v['itId']}&catId=$catId'>{$v['itName']}</a>
				</td>
				".( $bCommonList ? "<td class='frmcont' style='width:150px;'>[ ".GetCategoryName($v['itCatId'])." ]</td>" : "")."
				<td class='frmcontc' style='width:40px;'>{$v['itCount']}</td>
				<td class='frmcont'>".substr($v['itDesc'],0,50)."</td>
			</tr>";
	}
	else
	{
		echo "<tr class='frmcont'><td class='frmcont' style='text-align:center;' colspan='3'>Empty</td></tr>";
	}
	echo "</table></div><br>";
?>