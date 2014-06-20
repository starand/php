<?
	include_once "common.php";
	CheckUser();
	
	$schedules = GetSchdules();
	if( $schedules ) 
	{
		echo "<TABLE>";
		foreach( $schedules as $sched ) 
		{
			echo "<tr>";
			echo "<td>{$sched['schedId']}</td>";
			echo "<td>{$sched['schedExecTime']}</td>";
			echo "<td>{$sched['schedCommand']}</td>";
			echo "<td>{$sched['schedRepeatCount']}</td>";
			echo "<td>{$sched['schedRepeatTime']}</td>";
			echo "<td>{$sched['schedRepeatMultiplier']}</td>";
			echo "<td>{$sched['schedType']}</td>";
			echo "</tr>";
		}
		echo "</TABLE>";
	}
?>