<?
	include_once "../files/common.php";
	include_once "users.php";  

	$user = CheckUser();
	if(!$user) EchoErrorMsg("�� �� ���������������� ����������","../users/enter.php");

	// �������� �� ���� ������������
	if(!is_uploaded_file($_FILES["ava"]["tmp_name"]))
	{
		EchoErrorMsg("������� ������������� �����");
	}

	// �������� ������ �����
	if($_FILES["ava"]["size"] > 100*1024) // 100 kb
	{
		EchoErrorMsg ("����� ����� �������� 100 Kb");
	}	
	
	// �������� Content-Type
	if($_FILES['ava']['type'] !== "image/png") 
	{
		EchoErrorMsg("��������, ��������� ������������ ���� PNG ����� : ".$_FILES['ava']['type']);
	}
	
	// �������� ����� �����
	$imageinfo = getimagesize($_FILES['ava']['tmp_name']);
	if($imageinfo['mime'] != 'image/png') 
	{
		EchoErrorMsg("��������, ��������� ������������ ���� PNG ����� : ".$imageinfo['mime']);
	}

	// �������� ���������� �����
	$ext = substr($_FILES['ava']['name'], strrpos($_FILES['ava']['name'], ".")+1);
	if($ext !== "png")
	{
		EchoErrorMsg("�� ���� ���������� $ext!");
	}
	
	// �������� ������ ����������
	list($width, $height) = getimagesize($_FILES["ava"]["tmp_name"]);
	if($width > 100 || $height > 140)
	{
		EchoErrorMsg("�� ������� ������ ���������� : $height � $width");
	}
	
	$filename = $user['uNick'].".png";
	move_uploaded_file($_FILES["ava"]["tmp_name"], "../img/avatars/".$filename);
	$sql = "UPDATE users SET uAvatar='$filename' WHERE uId={$user['uId']}";
	uquery($sql);
	EchoErrorMsg("", "../files/main.php?script=profile");
?>