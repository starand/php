<?
	if( file_exists("common.php") ) include_once "common.php";
	else include_once "../../files/common.php";
	
	include_once ROOT_PATH."/users/users.php";	
	include_once "books.php";
	include_once ROOT_PATH."/forums/forums.php";
	
	$BOOK_BASE = "e:\\lab\\.books\\";
	
	if(!($user=CheckUser())) EchoErrorMsg("", "../users/enter.php");
	
	if(isset($_GET['bid']))
	{
		$bid = (int)$_GET['bid'];
		$book = GetBook($bid);
		
		if(!$book || !file_exists($book['bookPath'])) die("Book not found!");
		
		$book = trim($book['bookPath']);
		$book = str_replace("\\","/",$book);
		$shortname = basename($book);
		$size = (int)filesize($book);

		Header('Content-Description: File Transfer');
		if( !isset($_GET['read']) ) Header('Content-Disposition: attachment; filename="'.$shortname.'";');
		Header('Content-Transfer-Encoding: binary');
		Header('Content-Length: '.$size);
		Header('Content-Type: application/zip');

		$fhandle = fopen($book, "rb");
		AddLogMsg($user['uId'], "25|$bid",106);
		while($content = fread($fhandle,512)) echo $content;
		fclose($fhandle);
		IncBook($bid);		
	}
	else die("Error! Not set book id");
?>
