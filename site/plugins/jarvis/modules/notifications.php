<?
	if( !defined("ROOT") ) die();
	define( "DELIM", "<@>" );
	define( "MSG_DELIM", "<@@@>" );
	
##################################################################
##
function GetNotification( $nLastID = 0 )
{
	$sql = "SELECT * FROM notifications WHERE nId > $nLastID ORDER BY nId DESC LIMIT 50";
	$res = uquery( $sql );
	
	$result = array();
	for( ; $row = mysql_fetch_array($res); $result[] = $row );
	if( count($result) ) return array_reverse( $result );
	return 0;
}

function GetLastNotificationId()
{
	$sql = "SELECT nId FROM notifications ORDER BY nId DESC LIMIT 1";
	$res = uquery( $sql );
	if( $res && mysql_num_rows($res) ) return mysql_result( $res, 0, 0 );
	return 0;
}
##
function AddNotification( $msg, $title, $level )
{
	$sql = "INSERT INTO notifications VALUES( NULL, '".DelXSS($msg)."', '".DelXSS($title)."', ".(int)$level.", now() )";
	return uquery( $sql );
}
##################################################################
	
	$bDebug = isset( $_GET['debug'] );
	
	if( $bDebug )
	{
		echo "<body style='background:black;color:lightblue;font-family:verdana;'><center>";
	}

	## get list
	if( isset($_GET['list']) )
	{
		$lastId = (int)$_GET['list'];
		$nl = GetNotification( $lastId );
		
		if( $bDebug ) echo "<table style='font-size:10px;'>";
		
		$i = 0;
		if( $nl ) foreach( $nl as $n )
		{
			if( $bDebug )
			{
				echo "<tr style='background:#".( $i++ %2 == 0 ? "282828" : "313131").";'><td>{$n['nId']}</td><td>{$n['nMsg']}</td><td>{$n['nTheme']}</td><td>{$n['nLevel']}</td><td>{$n['nTime']}</td></tr>";
			}
			else 
				echo $n['nId'].DELIM.$n['nMsg'].DELIM.$n['nTheme'].DELIM.$n['nLevel'].DELIM.$n['nTime'].MSG_DELIM;
		}
		
		if( $bDebug ) echo "</table>";
	}
	
	## get last id
	if( isset($_GET['lastid']) )
	{
		echo GetLastNotificationId();
	}	
	
	## add notification
	if( isset($_GET['msg']) && isset($_GET['title']) && isset($_GET['level']) )
	{
		$msg = DelXSS( $_GET['msg'] );
		$title = DelXSS( $_GET['title'] );
		$level = (int)$_GET['level'];
		
		if( strlen($msg) )
		{
			AddNotification( $msg, $title, $level );
			echo "Notification added to queue";
		}
	}

?>