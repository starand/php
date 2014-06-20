<?
	if( !defined("ROOT") ) die();

##
function GetModulePath( $name )
{
	$sql = "SELECT mPath FROM modules WHERE mName='".DelXSS($name)."'";
	$res = uquery( $sql );
	
	if( mysql_num_rows($res) ) return mysql_result( $res, 0, 0 );
	return false;
}
	
?>