<?
	if(!defined("__DB__")) { 
	define("__DB__",1); //for multiply use
	include_once "config.php";
	
	// MySQL host
	$host = "localhost";	

	// MySQL user name
	$mysql_user = "stream"; 	
	
	// MySQL password
	$mysql_pswd = "hacker";

	// database name
	$db = "knowbase";
	
	//path to notes
	$path = "";

// connecting
	@mysql_pconnect($host,"stream",mysql_pswd) or die("Can not connect to database!!"); 
	mysql_select_db($db) or die("Can not select database!!");


## send query to db	
function uquery($query) 
{
	$result = @mysql_query($query) or die("Can not send query to database!!");
	return $result;
}
## return path 
function path()
{
	global $path;
	return $path;
}

// multiply use
}
?>