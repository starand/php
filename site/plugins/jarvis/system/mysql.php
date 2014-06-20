<?
	if( !defined("ROOT") ) die();
	
	// connecting
	@mysql_pconnect( $db_host, $db_user, $db_pswd ) or die( "Unable to connect to database" ); 
	mysql_select_db( $db_name ) or die( "Unable to select database" );

## send query to db	
function uquery($query) 
{
	$result = @mysql_query($query) or die( "Unable to send query to database" );
	return $result;
}

## delete XSS ijections symbols
function DelXSS(&$text) {
	$text = str_replace("'","`",$text);	$text = str_replace('"',"&quot;",$text);
	$text = str_replace("<","",$text);	$text = str_replace(">","",$text);
	return $text;
}
?>