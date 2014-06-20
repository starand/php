<?
	include_once "../../files/common.php";
	include_once "../../users/users.php";
	include_once "files.php";
	
	if( !($user=CheckUser()) ) EchoErrorMsg("","../../users/enter.php");
	
	echo "<div style='with:100%;text-align:center; color:red;font-family: tahoma; font-size:12px; font-weight:bold;'>";

	// var_dump( $_POST );	die();
	
	if( !isset($_POST['detId']) || !(int)$_POST['detId'] ) 
	{
		die( "Помилка завантаження" );
	}
	$detId = (int)$_POST[ 'detId' ];
	
	$fname = $_FILES['file']['name'];
	if( FileExists($fname) ) 
	{
		die( "Файл з таким іменем уже існує" );
	}
	
	if( !$_FILES['file']['tmp_name'] || ($_FILES['file']['size'] == 0) ) 
	{
		die("Помилка завантаження файлу");
	}
	
	if($_FILES['file']['size'] > 5*1024*1024)
	{
		die( "Розмір файлу більше ніж 5 Mb" );
	}
	
	// Перевірка розширення файлу
	$ext = substr($_FILES['file']['name'], strrpos($_FILES['file']['name'], ".")+1);
	$acceptedTypes = array( 'zip', 'rar', 'jpg', 'png', 'pdf', 'txt', 'c', 'cpp' );
	
	$bExists = false;
	foreach( $acceptedTypes as $type ) {
		if( $type === $ext ) {
			$bExists  = true;
			break;
		}
	}
	
	if( !$bExists )
	{
		die("Можна завантажувати файли таких типів : ".implode(',', $acceptedTypes)." <> ".$_FILES['file']['type']);
	}	
	
	set_time_limit(0);
	$tmpName = &$_FILES['file']['tmp_name'];
	uquery("SET max_allowed_packet=".(5*1024*1024+50));
	
	// echo $_FILES['file']['type'];
	if($_FILES['file']['type'] !== "application/x-rar-compressed" 
		&& $_FILES['file']['type'] !== "application/zip"
		&& $_FILES['file']['type'] !== "application/octet-stream"
		&& $_FILES['file']['type'] !== "image/jpeg"		
		&& $_FILES['file']['type'] !== "image/png"
		&& $_FILES['file']['type'] !== "application/pdf"
		&& $_FILES['file']['type'] !== "text/plain"
		)
	{
		die("Можна завантажувати лише zip або rar файли! ".$_FILES['file']['type']);
	}
	
	$fp = fopen($tmpName, 'r');
	$content = fread($fp, filesize($tmpName));
	fclose($fp);
	
	$content = addslashes($content);
	if( AddFile($fname, $fdesc, $content, $detId, $_FILES['file']['type']) )
	{	
		echo "<font color='#00FF00'>Файл завантажено успішно</font>";
	}
	else echo "Помилка завнтаження файлу";
?>

