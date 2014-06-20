<?
	include_once "functs.php";
	
	//add category from handler
	if( isset($_POST['cat']) && isset($_POST['desc']) )
	{
		$cat = DelXSS( $_POST['cat'] );
		$desc = DelXSS( $_POST['desc'] );
		AddCategory( $cat, $desc );
	}
	
	// add item form handler
	if( isset($_POST['item']) && isset($_POST['desc']) && isset($_POST['count']) && isset($_POST['catId']) )
	{
		$item = DelXSS( $_POST['item'] );
		$desc = DelXSS( $_POST['desc'] );
		$count = (int)$_POST['count'];
		$catId = (int)$_POST['catId'];
		
		if( isset($_POST['id']) && (int)$_POST['id'] ) 
		{
			$id = (int)$_POST[ 'id' ];
			UpdateItem( $id, $item, $desc, $count );
			$_GET['detId'] = $id;
		}
		else {
			AddItem( $item, $desc, $count, $catId );
		}
	}
	
	// var_dump( $_POST );
	// var_dump( $_GET );
	
	echo "<script src='	/forums/js/jquery.js'></script>";
	
	$catId = "itCatId";
	if( isset($_GET['catId']) ) $catId = (int)$_GET['catId'];
	
	echo "<table style='width:100%;'><tr><td style='width:200px; padding: 10px 10px 5px 10px;'>";
	
		$catList = GetCategories();
		echo "<div class='frmframe'><table class='frmlist' cellspacing='1'>";
		echo "<tr class='frmttl'><td class='frmttl' colspan='1'>Categories</td></tr>";
		
		if( $catList ) foreach($catList as $v) 
		{
			echo "<tr class='frmcont'><td class='frmcont'>";
			echo "<a href='/files/main.php?script=radio&catId={$v['catId']}'>{$v['catName']}</a>";
			echo "</td></tr>";
		}
		else
		{
			echo "<tr class='frmcont'><td class='frmcont' style='text-align:center;'>Empty</td></tr>";
		}
		echo "</table></div>";
		
		echo "<br><a href='/files/main.php?script=showmsg&mid=3754'>Radio Notes</a><br><br>";
		
		echo "<div class='frmframe'><table class='frmlist' cellspacing='1'>";
		echo "<tr class='frmttl'><td class='frmttl' colspan='2'>Add Category</td></tr>";
		echo "<form action='' method='post'>";
		echo "<tr class='frmcont'><td class='frmcont'><input type='text' name='cat' style='width:142px;'><input type='submit' value='Add'></td></tr>";
		echo "<input type='hidden' name='desc'>";		
		echo "</form>";
		echo "</table></div>";
		
	echo "</td><td style='padding: 10px 10px 10px 0px;'>";
		
		$detId = 0; $editId = 0;
		if( isset($_GET['detId']) ) $detId = (int)$_GET['detId'];
		if( isset($_GET['editId']) ) $editId = (int)$_GET['editId'];
		if( $detId )
		{
			include_once PLUGIN_PATH."detail.php";			
		}
		else if( $editId )
		{
			include_once "adddetail.php";
		}
		else
		{
			include_once PLUGIN_PATH."category.php";
		}
		
	echo "</td></tr></table>";
?>