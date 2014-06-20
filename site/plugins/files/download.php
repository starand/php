<?
	include_once "../../files/common.php";
	include_once "../../users/users.php";
	include_once "files.php";
	
	if(!($user=CheckUser())) EchoErrorMsg("","../../users/enter.php");
	if(!isset($_GET['fid'])) EchoErrorMsg("Не вказаний файл!","../../files/main.php");
	else $fid = (int)$_GET['fid'];
	
	$file = GetFile($fid);
	$content = GetFileCont($fid);
	if(!$content) EchoErrorMsg("Такий файл не знайдено!","../../files/main.php");
	
	Header('Content-Description: File Transfer');
	Header('Content-Disposition: attachment; filename="'.$file['fileName'].'";');
	Header('Content-Transfer-Encoding: binary');
	Header('Content-Length: '.strlen($content));
	Header('Content-Type: application/zip');

	echo $content;
?>