<?
	include_once "common.php";
	CheckUser();

	if( !isset($_POST['exectime']) || !isset($_POST['command']) || !isset($_POST['repeat_count']) 
		|| !isset($_POST['repeat_interval']) || !isset($_POST['multiplier']) || !isset($_POST['type']) ) {
?>
		<form action='' method='post'><table>
			<tr><td>Execute time</td><td><input type='text' name='exectime' value='2013-10-20 23:15:30'></td></tr>
			<tr><td>Command</td><td><input type='text' name='command'></td></tr>
			<tr><td>Repeat count</td><td><input type='text' name='repeat_count' value='1'></td></tr>
			<tr><td>Repeat interval</td><td>
				<select name='repeat_interval'>
					<option value='SECOND'>Second</option>
					<option value='MINUTE'>Minute</option>
					<option value='HOUR'>Hour</option>
					<option value='DAY'>Day</option>
					<option value='WEEK'>Week</option>
					<option value='MONTH'>Month</option>
					<option value='YEAR'>Year</option>
				</select>
			</td></tr>
			<tr><td>Every</td><td><input type='text' name='multiplier' value='1'></td></tr>
			<tr><td>Type</td><td><input type='text' name='type' value='1'></td></tr>
			<tr><td><input type='submit' name='type' value='Add Schedule'></td></tr>
		</table></form>
<?
	}
	else
	{
		$command = $_POST['command'];
		$exec_time = $_POST['exectime'];
		$repeat_count = (int)$_POST['repeat_count'];
		$repeat_interval = $_POST['repeat_interval'];
		$multiplier = (int)$_POST['multiplier'];
		$type = (int)$_POST['type'];
		AddSchedule( $command, $exec_time, $repeat_count, $repeat_interval, $multiplier, $type ); 
	}
?>