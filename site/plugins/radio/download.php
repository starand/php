<?
	if( !isset($_GET['fid']) || !(int)$_GET['fid'] ) die("Не вказаний файл!");
	
	include_once "../../files/common.php";
	include_once "../../users/users.php";
	include_once "files.php";
		
	$fid = (int)$_GET[ 'fid' ];
	
	$file = GetFile( $fid );
	$content = GetFileCont( $fid );
	if( !$content ) die("Такий файл не знайдено!");
	
	Header('Content-Description: File Transfer');
	if( !isset($_GET['view']) ) {
		Header('Content-Disposition: attachment; filename="'.$file['fileName'].'";');
	}
	Header('Content-Transfer-Encoding: binary');
	Header('Content-Length: '.strlen($content));
	Header('Content-Type: '.$file['fileType']);

	echo $content;
?>