<?
	include_once "../../files/common.php";
	include_once "../../users/users.php";
	include_once "files.php";
	
	if(!($user=CheckUser())) EchoErrorMsg("","../../users/enter.php");
	
	echo "<div style='with:100%;text-align:center; color:red;font-family: tahoma; font-size:12px; font-weight:bold;'>";
	if(!isset($_POST['filename']) || strlen($_POST['filename']) == 0)
	{
		die("�� ������� ��� �����");
	}
	$fname = DelXSS(basename($_POST['filename']));
	
	if(FileExists($fname))
	{
		die("���� � ����� ������ ��� ����");
	}
	
	if(!isset($_POST['filedesc']) || strlen($_POST['filedesc']) == 0)
	{
		die("�� ������� ���� �����");
	}
	$fdesc = DelXSS($_POST['filedesc']);
	
	if(!$_FILES['file']['tmp_name'] || ($_FILES['file']['size'] == 0))
	{
		die("������� ������������ �����");
	}
	
	if($_FILES['file']['size'] > 5*1024*1024)
	{
		die("����� ����� ����� �� 5 Mb");
	}
	
	// �������� ���������� �����
	$ext = substr($_FILES['file']['name'], strrpos($_FILES['file']['name'], ".")+1);
	if($ext !== "rar" && $ext !== "zip")
	{
		die("����� ������������� ���� zip ��� rar �����! ".$_FILES['file']['type']);
	}	
	
	set_time_limit(0);
	$tmpName = &$_FILES['file']['tmp_name'];
	uquery("SET max_allowed_packet=".(5*1024*1024+50));
	
	if($_FILES['file']['type'] !== "application/x-rar-compressed" 
		&& $_FILES['file']['type'] !== "application/zip"
		&& $_FILES['file']['type'] !== "application/octet-stream")
	{
		die("����� ������������� ���� zip ��� rar �����! ".$_FILES['file']['type']);
	}
	
	$fp = fopen($tmpName, 'r');
	$content = fread($fp, filesize($tmpName));
	fclose($fp);
	
	$content = addslashes($content);
	if(AddFile($fname, $fdesc, $content)) echo "<font color='#00FF00'>���� ����������� ������</font>";
	else echo "������� ����������� �����";
?>

