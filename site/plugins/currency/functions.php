<?
	include_once "db.php";
	

function get_usd_points($width, $height, $type)
{
	$points = Array();
	$offers = get_today_offers($type);
	
	$min_time = 3600; $max_time = 0; $max_rate = 0;
	
	$min_shown_rate = 27;
	$max_shown_rate = 28;
	
	foreach($offers as $offer)
	{
		$time_arr = explode(":", $offer["c_time"]);
		$time = $time_arr[0]*60 * $time_arr[1];
		
		if ($offer["c_rate"] < $min_shown_rate) continue;
		if ($offer["c_rate"] > 28) continue;
		
		$rate = $offer["c_rate"] - $min_shown_rate;
		
		if ($time > $max_time) $max_time = $time;
		if ($time < $min_time) $min_time = $time;
		if ($rate > $max_rate) $max_rate = $rate;
		
		$points[$time] = $rate;
	}
	
	ksort($points);

	$time_diff = $max_time - $min_time;
	$rate_diff = $max_shown_rate - $min_shown_rate;
	
	$result = Array();
	foreach($points as $time => $rate)
	{
		$y = $height - (int)($rate / $rate_diff *  $height);
		$x = (int)(($time - $min_time) / $time_diff * $width);
		$result[$x] = $y;
	}
	
	return $result;
}

?>