<?
	include_once "../files/common.php";
	include_once "../forums/forums.php";
	include_once "../forums/highlight.php";
	include_once "../users/users.php";

	if(!($user=CheckUser())) EchoErrorMsg("","../users/enter.php");

function GetPass()
{
	$query = "select * from pass order by pwdTime desc";
	$res = uquery($query); 
	for($result=array(); $row=mysql_fetch_array($res); $result[]=$row);
	if($res && mysql_num_rows($res)) return $result;
	return 0;
}

function GetUserPass($login, $pass)
{
	$query = "select * from pass where pwdLogin='$login' and pwdPass='$pass'";
	$res = uquery($query);
	if($res && mysql_num_rows($res)) return mysql_fetch_assoc($res);
	return 0;
}

	$ps = GetPass();
	echo "<tr><td colspan=2><input type='text' id='temp'><div id='passwords'><table>";
	if($ps) foreach($ps as $v)
	{
		echo "<tr><td class=quote>{$v['pwdLogin']}</td><td class=rc>{$v['pwdPass']}</td>";
		echo "<td><a href=http://{$v['pwdHost']} target=_balnk>{$v['pwdHost']}</a></td><td>".sGetFDate($v['pwdTime'])."</td></tr>";
	}
	echo "</table></div></td></tr>";
?>
<script src='../forums/js/jquery.js'></script>
<script>
$(document).ready(function(){

	$('#temp').keyup(function()
	{
		$.ajax({
			type: "POST",
			url: "../forums/getpass.php",
			data: "login="+$("#temp").val(),
			success: function(html){
				$("#passwords").html(html);
			}
		});

		return true;
	});

});
</script>

<tr style='height:1px;'><td class=hline colspan=2></td></tr>