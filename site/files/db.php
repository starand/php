<?
	if(!defined("__DB__")) { 
	define("__DB__", 1);
    
	include_once "config.php";
	
	// MySQL host
	$host = "localhost";	

	// MySQL user name
	$mysql_user = "stream"; 	
	
	// MySQL password
	$mysql_pswd = "hacker";

    # connecting
	@mysql_pconnect($host,mysql_user,mysql_pswd) or die("Can not connect to database!!"); 
	mysql_select_db(db_name) or die("Can not select database!!");


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