<?
function GetPeoples($where) {
	$query = "SELECT * FROM hack.peoples WHERE $where limit 100";
	$res = uquery($query);
	for($result=array(); $row=mysql_fetch_array($res); $result[]=$row);
	if(count($result)) return $result;
	return 0;
}
?>