<?
if(!defined("__DB__")) {
  
	define("__DB__", 1);
    
	include_once "config.php";
	
	// MySQL host
	$db_host = "localhost";	
	// MySQL user name
	$mysql_user = "stream"; 	
	// MySQL password
	$mysql_pswd = "hacker";

    # connecting
	$conn = @mysql_pconnect(db_host,mysql_user,mysql_pswd) or die("Can not connect to database!!"); 
	mysql_select_db(db_name) or die("Can not select database!!");

	// set UTF8 as default connection
	mysql_query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'", $conn);
	//$re = mysql_query('SHOW VARIABLES LIKE "%character_set%";')or die(mysql_error());
	//while ($r = mysql_fetch_assoc($re)) {var_dump ($r); echo "<br />";} exit;

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

//-------------------------------------------------------------------------------------------------
// Currency

function get_today_offers($type)
{
	$sql = "SELECT * FROM currency WHERE c_date=CURDATE() AND c_type=$type";
	$res = uquery($sql);
	for($result=array(); $row=mysql_fetch_array($res); $result[]=$row);
	return $result;
}

function get_all_offers()
{
	$sql = "SELECT * FROM currency";
	$res = uquery($sql);
	for($result=array(); $row=mysql_fetch_array($res); $result[]=$row);
	return $result;
}



} // multiply use
?>