<?
	include_once "../files/common.php";
	include_once "users.php";  

	$user = CheckUser();
	if(!$user) EchoErrorMsg("Ви не аутентифікований користувач","../users/enter.php");

	// Перевірка чи файл завантажився
	if(!is_uploaded_file($_FILES["ava"]["tmp_name"]))
	{
		EchoErrorMsg("Помилка заванитаження файлу");
	}

	// Перевірка розміру файлу
	if($_FILES["ava"]["size"] > 100*1024) // 100 kb
	{
		EchoErrorMsg ("Розмір файлу перевищує 100 Kb");
	}	
	
	// Перевірка Content-Type
	if($_FILES['ava']['type'] !== "image/png") 
	{
		EchoErrorMsg("Звиняйте, дозволене завантаження лише PNG файлів : ".$_FILES['ava']['type']);
	}
	
	// Перевірка вмісту файлу
	$imageinfo = getimagesize($_FILES['ava']['tmp_name']);
	if($imageinfo['mime'] != 'image/png') 
	{
		EchoErrorMsg("Звиняйте, дозволене завантаження лише PNG файлів : ".$imageinfo['mime']);
	}

	// Перевірка розширення файлу
	$ext = substr($_FILES['ava']['name'], strrpos($_FILES['ava']['name'], ".")+1);
	if($ext !== "png")
	{
		EchoErrorMsg("Не вірне розширення $ext!");
	}
	
	// Перевірка розмірів зображення
	list($width, $height) = getimagesize($_FILES["ava"]["tmp_name"]);
	if($width > 100 || $height > 140)
	{
		EchoErrorMsg("Не коректні розміри зображення : $height х $width");
	}
	
	$filename = $user['uNick'].".png";
	move_uploaded_file($_FILES["ava"]["tmp_name"], "../img/avatars/".$filename);
	$sql = "UPDATE users SET uAvatar='$filename' WHERE uId={$user['uId']}";
	uquery($sql);
	EchoErrorMsg("", "../files/main.php?script=profile");
?>