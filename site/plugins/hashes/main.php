<?
	include_once "../files/common.php";
	include_once "hashes.php";
	if(!($user=CheckUser())) EchoErrorMsg("","../users/enter.php");

	// PREPARING VARIABLES
	if(isset($_POST['hashes'])) $hashes = DelXSS($_POST['hashes']);
	if(isset($_POST['decrypt'])) $decrypt = 1;
	if(isset($_POST['addpass'])) $addpass = 1;
	
?>
<center><br>
<?
	if(isset($decrypt)) {
		$f = split("\r\n",$hashes);
		foreach($f as $v)
		{
			if(strpos($v,':')===false) $str=$v; 
			elseif(isset($mysql)) $str = "*".substr($v,strpos($v,":")+1,40);
				else $str = substr($v,strpos($v,":")+1,32);
			//echo $str."<br>\r\n";
			$query = "insert into hack.t (hash) values('$str')";
			uquery($query);
		}
		if(isset($mysql)) $query = "select pass,mysql as md5 from hack.hashes,hack.t where mysql=hash";
		else $query = "select pass,md5 from hack.hashes,hack.t where md5=hash";
		$res = uquery($query);
		for($result=array(); $row=mysql_fetch_array($res); $result[]=$row);
		echo count($f)." hashes loaded. <b>Search ".count($result)."</b><br>";
		echo "<table style='font-size:12px;'>";
		if(count($result)) foreach($result as $k=>$v)
		{
			echo "<tr style='background:#222222;'><td>&nbsp;{$v['pass']}&nbsp;</td><td style='color:white'>&nbsp;{$v['md5']}&nbsp;</td></tr>";
		} else {
			echo "<tr><td>Empty set<br><br></td><tr>";
		}
		echo "</table>";
		$query = "delete from hack.t";
		$res = uquery($query);	
		echo "<br>Hashes deleted from temp table";
	}

	$c = GetHashesCount();	
	if(isset($addpass)) {
		$A = split("\r\n",$hashes);
		if(count($A)) foreach($A as $v) AddHash($v);
		$d = GetHashesCount();
		echo "<font color=red><b>".($d-$c)."</b></font> хешів додано!<br>";
		echo $d." хешів в базі<br><br>";
	}	


?>

<div class='frmframe' style='width:500px;'><table class='frmlist' style='background:#313131;' cellspacing='1'>
<tr class='frmttl'><td colspan='2' class='padding' style='text-align:center;font-weight:bold;'>Hash cracking</td></tr>
<form action='' method=post actions='actions'>
<tr><td colspan=2 class='padding' style='text-align:center'>
Enter hashes/passwords, each of new line.<br>Hashes can be optimized for PasswordsPro:<br>
	<textarea name='hashes' cols='65' rows='15' style='background:black;color:white;'></textarea><br>
</td></tr>
<tr><td style='font-size:10px;' class='padding'>
<input type=submit value='Decrypt' name='decrypt'>
<input type=checkbox name=mysql style='border:0px;'> MySQL
</td><td style='text-align:right;' class='padding'>
	<input type=submit value='Add pass' name='addpass'> &nbsp; 
</td></tr>
</form>
</table></div>
<br><br>
<div>В базі <b><?=GetHashesCount();?></b> паролів</div>