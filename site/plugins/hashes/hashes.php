<?
// get pass by md5
function GetPassByMd5($md5) {
	$query = "select pass from hack.hashes where md5='$md5'";
	$res = uquery($query);
	if(mysql_num_rows($res)) return mysql_result($res,0,0);
	return "не знайдено!!";	
}
// return hashes count
function GetHashesCount() {
	$query = "select count(*) from hack.hashes";
	$res = uquery($query);
	if(mysql_num_rows($res)) return mysql_result($res,0,0);
	return 0;
}
// add new hash to db
function AddHash($pass) {
	$query = "insert ignore into hack.hashes (pass,md5,mysql) values('$pass',md5('$pass'),password('$pass'))";
	return @uquery($query);
}
function GetPeoples($where) {
	$query = "SELECT * FROM hack.peoples WHERE $where";
	$res = uquery($query);
	for($result=array(); $row=mysql_fetch_array($res); $result[]=$row);
	if(count($result)) return $result;
	return 0;
}
?>