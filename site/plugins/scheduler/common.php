<?
	session_start();
	header( 'Content-Type: text/html; charset=windows-1251' );
	
## display error and exit
function ErrorMsg( $msg )
{
	die( "<font color='red'>$msg</font>" );
}

## check if user is authentified
function CheckUser()
{
	if( !isset($_SESSION["n_user"]) || $_SESSION["n_user"]["uNick"] !== "StarAnd") ErrorMsg( "Not authorized" );
}
	
	$db_host = "localhost";
	$db_user = "stream";
	$db_pswd = "limit 5";
	$db_name = "scheduler";

	@mysql_pconnect( $db_host, $db_user, $db_pswd ) or die( "Can not connect to database!!" ); 
	mysql_select_db( $db_name ) or die( "Can not select database!!" );
	

## send query to db	
function uquery( &$query )
{
	$result = @mysql_query($query) or die("Can not send query to database!!");
	return $result;
}

function GetSchdules()
{
	$sql = "SELECT * FROM schedules";
	$res = uquery( $sql );
	if( !$res || !mysql_num_rows($res) ) return 0;
	
	for( $result=array(); $row=mysql_fetch_array($res); $result[]=$row );
	return $result;
}

function AddSchedule( $command, $exec_time, $repeat_count, $repeat_interval, $multiplier, $type )
{
	$sql = "INSERT INTO schedules VALUES( NULL, '$exec_time', '$command', $repeat_count, '$repeat_interval', $multiplier, $type )";
	return uquery( $sql );
}

?>