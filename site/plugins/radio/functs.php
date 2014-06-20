<?
	define( 'BASE_PATH', 'e:/sources/php/site/' );
	define( 'PLUGIN_PATH', 'e:/sources/php/site/plugins/radio/' );
	include_once BASE_PATH."files/common.php";

function GetCategories()
{
	$sql = "SELECT * FROM radio.categories ORDER BY catName";
	$res = uquery( $sql );
	for( $result = array(); $row = mysql_fetch_array($res); $result[] = $row );
	if( count($result) ) return $result;
	return 0;
}

function GetCategory( $catId )
{
	$sql = "SELECT * FROM radio.categories WHERE catId=$catId";
	$res = uquery( $sql );
	if( $res && mysql_num_rows($res) ) return mysql_fetch_array( $res );
	return 0;
}

function GetCategoryName( $catId )
{
	$sql = "SELECT catName FROM radio.categories WHERE catId=$catId";
	$res = uquery( $sql );
	if( $res && mysql_num_rows($res) ) return mysql_result( $res, 0, 0 );
	return "";
}

function AddCategory( $name, $desc="" )
{
	$sql = "INSERT INTO radio.categories VALUES( NULL, '$name', '$desc' )";
	return uquery( $sql );
}

function GetItems( $catId, $searchStr )
{
	$WHERE = "WHERE itCatId=$catId";
	if( strlen($searchStr) ) $WHERE .= " AND ( itName LIKE '%$searchStr%' OR itDesc LIKE '%$searchStr%')";
	
	$sql = "SELECT * FROM radio.items $WHERE";
	$res = uquery( $sql );
	for( $result = array(); $row = mysql_fetch_array($res); $result[] = $row );
	if( count($result) ) return $result;
	return 0;	
}

function GetItem( $itemId )
{
	$sql = "SELECT * FROM radio.items WHERE itId=$itemId";
	$res = uquery( $sql );
	if( $res && mysql_num_rows($res) ) return mysql_fetch_array( $res );
	return 0;
}

function AddItem( $name, $desc, $count, $cat )
{
	$sql = "INSERT INTO radio.items VALUES( NULL, '$name', $cat, '$desc', $count )";
	return uquery( $sql );	
}

function UpdateItem( $id, $name, $desc, $count )
{
	$sql = "UPDATE radio.items SET itName='$name', itDesc='$desc', itCount='$count' WHERE itId=$id";
	return uquery( $sql );	
}

function AddTransDetail($name, $analog, $repl)
{
	$sql = "INSERT INTO radio.transistors VALUES( NULL, '$name','$analog','$repl')";
	return uquery( $sql );
}

function GetAllTransDetails()
{
	$sql = "SELECT * FROM radio.transistors";
	for( $result = array(); $row = mysql_fetch_array($res); $result[] = $row );
	if( count($result) ) return $result;
	return 0;
}

function GetTransDetails( $name="" )
{
	$WHERE = "";
	if( strlen($name) ) $WHERE = "WHERE trName LIKE '%$name%' OR trAnalogue LIKE '%$name%' OR trReplacement LIKE '%$name%'";
	$sql = "SELECT * FROM radio.transistors $WHERE";
	$res = uquery( $sql );
	for( $result = array(); $row = mysql_fetch_array($res); $result[] = $row );
	if( count($result) ) return $result;
	return 0;
}

?>