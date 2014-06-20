<?
	include_once "common.php";
	include_once "../forums/forums.php";
	include_once "../users/users.php";
	
	if(!($user=CheckUser())) EchoErrorMsg("","../users/enter.php");
	
function ShortName( $fileName )
{
	$fn = basename( trim($fileName) );
	$ext = "";
	if( ($pos = strrpos($fn, ".")) !== false )
	{
		$ext = substr($fn, $pos);
		$fn = substr($fn, 0, $pos);
	}
	
	if( strlen($fn) > 20 ) $fn = substr($fn, 0, 18)."..";
	$fn .= $ext;
	return $fn;
}

	$BOOK_BASE = "e:\\lab\\.books\\";
	
	$book = GetRandomBook();
	if( !$book ) die( "There is no books yet!" );
	$size = (int)filesize( $BOOK_BASE.$book['bookPath'] );
	$size -= $size % 10000;
	$size /= 1000000;
	

	echo "<div class='frmframe'><table class='frmlist' cellspacing='1' style='font-size:10px;'>";
		echo "<tr class='frmttl'><td class='padding'>Books <a href='/files/main.php?script=books'>..</a> </td></tr>";
		echo "<tr><td class='padding' style='background:#282828;text-align:center;'>";
		echo "<a href='../plugins/books/download.php?bid={$book['bookId']}' title='".strip_tags($book['bookDesc'])."'><img style='width:170px;' src='/plugins/books/screenshots/{$book['bookImage']}'><br>".ShortName($book['bookPath'])." [{$size} Mb]</a></td></tr>";
	echo "</table></div>";	
?>