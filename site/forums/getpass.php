<?
	include_once "../files/common.php";
	include_once "../forums/forums.php";
	include_once "../forums/highlight.php";
	include_once "../users/users.php";

	if(!($user=CheckUser())) EchoErrorMsg("","../users/enter.php");
	if(!isset($_POST['login'])) die();
	else $login = $_POST['login'];

function GetPass($login)
{
	$query = "select * from pass where pwdLogin like'$login%' order by pwdTime desc";
	$res = uquery($query); 
	for($result=array(); $row=mysql_fetch_array($res); $result[]=$row);
	if($res && mysql_num_rows($res)) return $result;
	return 0;
}

	$ps = GetPass($login);
	echo "<table>";
	if($ps) foreach($ps as $v)
	{
		echo "<tr><td class=quote>{$v['pwdLogin']}</td><td class=rc>{$v['pwdPass']}</td>";
		echo "<td><a href=http://{$v['pwdHost']} target=_balnk>{$v['pwdHost']}</a></td><td>".sGetFDate($v['pwdTime'])."</td></tr>";
	}
	echo "</table>";


?>