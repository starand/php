<?
	session_start();
	header('Content-Type: text/html; charset=windows-1251');

	define( 'SMART_HOUSE', '1.0' );
	define( 'ROOT_PATH', "e:/sources/php/site/plugins/smh/" );

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
	
?>