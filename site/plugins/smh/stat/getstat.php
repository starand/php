<?
	include_once "db.php";
	
	$sql = "select *, (TO_DAYS(liTime)-730486)*86400+TIME_TO_SEC(liTime) as SECONDS from lightInfo where liRoom=2 order by liId";
	$res = uquery($sql);

	$timeArray = array();
	$startTime = 0; $endTime = 0;
	
	while ($row = mysql_fetch_array($res))
	{
		if ($row['liState'] == 1)
		{
			$startTime = $row['SECONDS'];
		}
		else
		{
			$endTime = $row['SECONDS'];
			if ($startTime != 0)
			{
				$timeDif = $endTime - $startTime;
				if ($timeDif > 5)
				{
					$timeArray[] = $timeDif;
				}
				$startTime = 0;
			}
		}
	}
	
	$count = count($timeArray);
	$sum = 0;
	//sort($timeArray);
	foreach($timeArray as $v)
	{
		$sum += $v;
	}
	
	echo "AVG : ".($sum/$count);

	
?>