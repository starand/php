<?
	include_once "../files/common.php";
	include_once "peoples.php";
	if(!($user=CheckUser())) EchoErrorMsg("","../users/enter.php");
	
	if(isset($_GET['lname'])) $lname= $_GET['lname'];
	if(isset($_GET['name'])) $name= $_GET['name'];
	if(isset($_GET['mname'])) $mname= $_GET['mname'];
	if(isset($_GET['birthday'])) $birthday= $_GET['birthday'];
	if(isset($_GET['town'])) $town= $_GET['town'];
	if(isset($_GET['street'])) $street= $_GET['street'];
	if(isset($_GET['house'])) $house= $_GET['house'];
	if(isset($_GET['flat'])) $flat= $_GET['flat'];
		
?>
<br><br><center>

<form action="" name=peoples>
<div class='frmframe' style='width:730px;'><table class='frmlist' style='background:#313131;' cellspacing='1'>
<tr class='frmttl'><td colspan='8' class='padding' style='text-align:center;font-weight:bold;'>Пошук людей по Червонограду</td></tr>

<tr style='font-size:12px;'>
<td>Прізвище</td><td>І'мя</td><td>По батькові</td><td>День/Н.</td><td>Місто</td><td>Вулиця</td><td>Будинок</td><td>Квартира</td>
</tr>
<tr>
<td><input type=text size=10 name='lname' style="color:#FFFF00; font-weight:bold;"></td>
<td><input type=text size=10 name='name' style="color:#FFFF00; font-weight:bold;"></td>
<td><input type=text size=10 name='mname' style="color:#FFFF00; font-weight:bold;"></td>
<td><input type=text size=9 name='birthday' style="color:#FFFF00; font-weight:bold;"></td>
<td><input type=text size=10 name='town' style="color:#FFFF00; font-weight:bold;"></td>
<td><input type=text size=10 name='street' style="color:#FFFF00; font-weight:bold;"></td>
<td><input type=text size=6 name='house' style="color:#FFFF00; font-weight:bold;"></td>
<td><input type=text size=6 name='flat' style="color:#FFFF00; font-weight:bold;"></td>
</tr>
<tr><td colspan='8' style='text-align:center;'><input type='button' onclick="peoples.submit()" value='Пошук'></td></tr>

</table></div>

</form>
<br>
<a href='http://www.nomer.org/allukraina/'>Пошук людей по Україні</a>  (дані вводити по рос.)


<? 
	if(isset($lname) && isset($name) && isset($mname) && isset($town) && isset($street) 
			&& isset($house) && isset($flat) && isset($birthday)) 
	{
		DelXSS($lname); DelXSS($name); DelXSS($mname); DelXSS($town);
		$where = "1=1";
		if($lname!=="") $where.=" and psLastName like '$lname'";
		if($name!=="") $where.=" and psName like '$name'";
		if($mname!=="") $where.=" and psMiddleName like '$mname'";
		if($birthday!=="") $where.=" and psBirthday like '$birthday'";
		if($street!=="") $where.=" and psStreet like '$street'";
		if($house!=="") $where.=" and psHouse like '$house'";
		if($flat!=="") $where.=" and psFlat like '$flat'";						
		$list = GetPeoples($where);
		if($list) {
			echo "<table style='width:100%; font-size:13px'>";
			echo "<tr style='background:#000066'><td>#</td><td>Name</td><td>City</td><td>Street</td><td>Birthday</td><td>BirthPlace</td></tr>";
			foreach($list as $k=>$v) {
				echo "<tr ".($k%2 ? "style='color:white'" : "style='color:yellow;'").">";
				echo "<td style='width:20px;'>".($k+1)."</td>";
				echo "<td>{$v['psLastName']} {$v['psName']} {$v['psMiddleName']}</td>";
				echo "<td>{$v['psTown']}</td>";
				echo "<td>{$v['psStreet']} {$v['psHouse']}/{$v['psFlat']}</td>";
				echo "<td>{$v['psBirthday']}</td>";
				echo "<td>{$v['psBirthPlace']}</td>";	
				echo "</tr>";		
			}
			echo "</table>";
		}
		else echo "Результат: <b style='color:red;'>По даному запиту нічого незнайдено!!</b><br><br>";
		
	}
