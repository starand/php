<?
	include_once "functions.php";
	
	$width = 1000;
	$height = 400;
	
	$shift_x = 10; $shift_y = 10;
	
	$points = get_usd_points($width-25, $height-20, 100);
    $points_lviv = get_usd_points($width-25, $height-20, 0);
	
	$pt_str = ""; $start_x = 0; $start_y = 0;
	foreach($points as $time => $rate)
	{
		if ($pt_str) $pt_str .= ", ";
		else { $start_x = $time + $shift_x; $start_y = $rate + $shift_y; }
		
		$pt_str .= ($time + $shift_x).", ".($rate + $shift_y);
	}

    $pt_str_lviv = "";
    foreach($points_lviv as $time => $rate)
	{
		if ($pt_str_lviv) $pt_str_lviv .= ", ";
		
		$pt_str_lviv .= ($time + $shift_x).", ".($rate + $shift_y);
	}

	echo "$pt_str_lviv<br><br>";
	
?>
<canvas id="canvas" width="<?=$width;?>" height="<?=$height;?>"></canvas>

<script src="curve.js"></script>

<script>
    var canvas = document.getElementById("canvas");
    var ctx = canvas.getContext("2d");

    ctx.fillStyle = "black";
    ctx.fillRect(0, 0, canvas.width, canvas.height);

    ctx.fillStyle = "white";
    ctx.font = "12px Arial red";

    ctx.fillText("27", 0, 390-270+4);

    ctx.beginPath();
    ctx.moveTo(15, 390-270);
    ctx.lineTo(25, 390-270);
    ctx.strokeStyle = 'white';
    ctx.stroke();


    ctx.beginPath();
    ctx.moveTo(20, 10);
    ctx.lineTo(20, 400);
    
    ctx.moveTo(0, 390);
    ctx.curve([490, 390]);

    ctx.strokeStyle = '#5555ff';
    ctx.stroke();

    ctx.beginPath();
	
<?
	echo "ctx.moveTo($start_x ,$start_y);"
?>
    ctx.curve([<?=$pt_str;?>]);                 // add cardinal spline to path

    ctx.strokeStyle = '#00ff00';
    ctx.stroke(); 


    ctx.beginPath();
	
<?
	echo "ctx.moveTo($start_x ,$start_y);"
?>
    ctx.curve([<?=$pt_str_lviv;?>]);                 // add cardinal spline to path
    ctx.strokeStyle = '#ff0000';
    ctx.stroke(); 


</script>