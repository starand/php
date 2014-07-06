<?
	session_start();
	header('Content-Type: text/html; charset=windows-1251');

	define( 'SMART_HOUSE', '1.0' );
	define( 'ROOT_PATH', "e:/sources/php/site/plugins/smh/" );

	$password = "test_password";
	
	include_once ROOT_PATH."/config/config.php";
	

function ApplyCSS()
{
	echo "<HEAD><LINK href='misc/main.css' rel=stylesheet type=text/css></HEAD>";
}

function GetIsMobile()
{
	$pos = strpos($_SERVER['HTTP_USER_AGENT'], "SAMSUNG-GT-S5222");
	return ( $pos !== false );
}	

function AddCommonInfo(&$packet)
{
	global $_SERVER;
	$packet['request']['client'] = array('ip' => $_SERVER['REMOTE_ADDR'], 'tool' => 'site' );
}


function ShowSimpleButton($name, $id, $width = 40, $height = 40)
{
	echo "<a id='$id' class='buttonOn' style='width:{$width}px;height:{$height}px;line-height:{$height}px;vertical-align:middle;'>$name</a> ";
}

function ShowMusicButtons()
{
	ShowSimpleButton('<<', 'backward');
	ShowSimpleButton('>', 'play');
	ShowSimpleButton('||', 'pause');
	ShowSimpleButton('>>', 'forward');
	echo "&nbsp; ";
	ShowSimpleButton('+', 'volplus');
	ShowSimpleButton('-', 'volminus');
}
	
?>