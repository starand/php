<?
	include_once "../files/common.php";
	include_once "books.php";
	include_once "../users/users.php";
	include_once "../forums/highlight.php";
	
	if(!($user = CheckUser())) EchoErrorMsg("","../users/enter.php");
	echo "<br>";

	if(isset($_GET['path']) && isset($_GET['desc']) && isset($_GET['bcat']) && $user['uId']==1)
	{
		$path = trim($_GET['path']);
		DelQuotes($path);
		$bcat = (int)$_GET['bcat'];
		$desc = DelXSS($_GET['desc']);
		
		if( !$bcat || !strlen($path) || !strlen($desc) ) die("Не вірні дані! $QUERY_STRING");
		AddBook($path, PrepareMsg($desc), $bcat);
	}
	
	if(isset($_GET['newcat']))
	{
		$nc = DelXSS($_GET['newcat']);
		AddBookCat($nc);
	}

	$bcat = (int)@$_GET['bcat'];
	$cat = GetBookCat($bcat);
	
	$catId = 0;
	if($cat) 
	{
		echo "<a href=# class='path' style='color:magenta;'>{$cat['bcDesc']}/</a>";
		$catId = $cat['bcId'];
	}
	
	$bcats = GetBookCats($catId);
	if(!$bcats) $bcats = GetBookCats($cat['bcPid']);
	
	echo "<center><table><tr><td>";
	ShowCatList($bcats);
	if($user['uId'] == 1) ShowAddCatDlg();
	
	echo "</td><td>";
	if( $cat )
	{
		ShowBooks($bcat);
		if($user['uId'] == 1) 
		{
			echo "<br>";
			ShowAddBookDlg($catId);
		}
	}
	else
	{
		echo "<center><h2>Останні поступлення</h2></center>";
		ShowBooks();
	}
	
	echo "</td></tr></table>";
?>