<? if ( $_SESSION["n_user"]["uNick"] != "StarAnd" ) die(); ?>
<HEAD><LINK href='/themes/green/main.css' rel=stylesheet type=text/css>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8'></HEAD>
<?
function cat_color($id)
{
	switch($id)
	{
		case 1: return "#610B4B";
		case 2: return "#2E2E2E";
		case 3: return "#B43104";
		case 4: return "#0B3B0B";
		case 5: return "#0B0B61";
		case 6: return "#B40404";
		case 7: return "#868A08";
	}
}

function cost_color( $type )
{
	switch ( $type )
	{
	case 0: return "#000000";
	case 1: return "blue";
	case 2: return "green";
	}
}

function prepare_time($time)
{
	$day = substr($time, 8, 2);
	$month = substr($time, 5, 2);
	return $day.".".$month;
}

function get_prev_month_url($months)
{
	$month = (int)date('m');
	$year = (int)date('Y');
	
	if ( $months >= $month ) // calculate month and year
	{
		$month = 12 - ($months - $month);
		$year -= 1;
	}
	else
	{
		$month -= $months;
	}

	if ($month < 10) $month = "0".$month; // correct month representation

	$time = "$month.$year";
	$time_url = str_replace(".", "&year=", $time);
	
	return "<a href='?month=$time_url'>$time</a>";
}

	include_once "db.php";
	$consts = get_consts( );

function get_planned_costs( $id )
{
	global $consts;

	switch ( $id )
	{
		case 1: return $consts["MAX_COSTS_FOOD"];
		case 2: return $consts["MAX_COSTS_ETC"];
		case 3: return $consts["MAX_COSTS_CHILDREN"];
		case 4: return $consts["MAX_COSTS_WIFE"];
		case 5: return $consts["MAX_COSTS_ME"];
		case 6: return $consts["MAX_COSTS_CAR"];
		case 7: return $consts["MAX_COSTS_PERCENTAGE"];
		case 8: return $consts["MAX_COMMUNAL"];
	}

	return "error";
}

#################################################################
## Global Vars

	$month = isset($_GET['month']) ? (int)$_GET['month'] : date('m');
	$year = isset($_GET['year']) ? (int)$_GET['year'] : date('Y');
	$category = isset($_GET['cat']) ? (int)$_GET['cat'] : 0;

#################################################################

function cat_link($name, $id)
{
	global $month;
	global $year;

	$style = "text-decoration:none;";
	return "<a style='$style' href='?cat=$id&month=$month&year=$year'>{$name}</a>";
}
?>

<h1>Finance</h1>
<?
	echo get_prev_month_url(0)." | ".get_prev_month_url(1)." | ".get_prev_month_url(2)." | ".get_prev_month_url(3);
?>
<table>
	<tr>
		<td>
			<table cellspacing=5 cellpadding=10>
				<tr>
					<td style='border: 1px solid blue;'><h2>Add Cost Category</h2><? include_once "add_cost_category_dlg.php"; ?></td>
					<td style='border: 1px solid blue;'><h2>Add Income Category</h2><? include_once "add_income_category_dlg.php"; ?></td>
				</tr>
				<tr>
					<td style='border: 1px solid blue;'><h2>Add Cost</h2><? include_once "add_cost_dlg.php"; ?></td>
					<td style='border: 1px solid blue;'><h2>Add Income</h2><? include_once "add_income_dlg.php"; ?></td>
				</tr>
				<tr>
					<td>
						<?
							echo "<h2>Incomes</h2>";
							$income_total = get_incomes_sum($month, $year, $category);
							$cats = get_income_categories();
							$incomes = get_incomes_per_month($month, $year, $category);
							
                            echo "<table><tr><td>";
                            
                                echo "Total: <span style='color:#00FF00;'>".(float)$income_total."</span>";
                                echo "<table cellspacing='0' cellpadding='0'>";
                                foreach($incomes as $income)
                                {
                                    $cat_id = $income['i_cat'];
                                    $time = prepare_time($income['i_time']);
                                    $cat_name = $cats[$cat_id]["ic_name"];
                                    
                                    echo "<tr title='{$income['i_id']}'>";
                                    echo "<td style='border: 1px solid blue;'> $time </td>";
                                    echo "<td style='border: 1px solid blue;'> $cat_name </td>";
                                    echo "<td style='border: 1px solid blue;'> {$income['i_value']} </td>";
                                    echo "<td></td><td></td>";
                                    echo "</tr>";
                                }
                                echo "</table>";
                            
                            echo "<td><td>";
                            
                                $cat_sums = get_incomes_by_cats($month, $year);
                                echo "By categories:";
                                echo "<table cellspacing='0' cellpadding='0'>";
                                foreach( $cat_sums as $id => $sum )
                                {
                                    $cat_name = $cats[$id]["ic_name"];
                                    $cat_id = $cats[$id]["ic_id"];
                                    echo "<tr>".
                                            "<td style='border: 1px solid blue;'>".cat_link($cat_name, $cat_id)." </td>".
                                            "<td style='border: 1px solid blue;'> $sum</td>".
                                         "</tr>";
                                }
                                echo "</table>";
                            
                            echo "<td></tr></table>";
							
							echo "Category: <select name='i_cat' onSelect='alert(1);'>";
							foreach( $cats as $cat)
							{
								echo "<option value='{$cat[ic_id]}'>{$cat[ic_name]}</option>";
							}
							echo "</select>";
						?>
					</td>
					<td>
					<?
						echo "<h2>Costs</h2>";
						$cat_sums = get_costs_by_cats($month, $year);
						$cost_total = get_costs_sum($month, $year, $category);
						$cats = get_cost_categories();
						$progress = round( (int)date("j") / (int)date("t") * 100, 2 );
						echo "<BR>By categories ( $progress % ): <table cellspacing='0' cellpadding='0'>";
						$planned_total = 0;
						foreach( $cat_sums as $id => $sum )
						{
							$cat_name = $cats[$id]["cc_name"];
							$cat_id = $cats[$id]["cc_id"];
							$planned = get_planned_costs($id);
							$planned_total += $planned;
							$curr_progress = round( $sum / $planned * 100, 2);
							echo "<tr>".
									"<td style='border: 1px solid blue;'>".cat_link($cat_name, $cat_id)." </td>".
									"<td style='border: 1px solid blue;'> $sum</td>".
									"<td style='border: 1px solid blue; color: ".($curr_progress > $progress ? "red" : "white")."' title='$planned'>".
									"&nbsp; $curr_progress % &nbsp; </td>".
								 "</tr>";
						}
						echo "</table><BR>";
						$planned_prec = round($cost_total / $planned_total * 100, 2);
						echo "Total planned: $planned_total, <b style='color: ".($planned_prec > $progress ? "red" : "white")."'>$planned_prec</b> % used";
					?>
					</td>
				</tr>
			</table>
		</td>
		<td rowspan='3' style='border: 1px solid blue;'>
			<?
				$days = date('j');
				echo "<h2>Costs</h2>Total: <span style='color:red;'>".(float)$cost_total."</span>, Net profit: ".($income_total - $cost_total);
				echo "<br>Per day: ".round($cost_total/$days);
			?>
			<table cellspacing='0' cellpadding='0'><tr><td>
			<?
				$costs = get_costs_per_month($month, $year, $category);

				$counter = 0;
				echo "<table cellspacing='0' cellpadding='0'>";
				foreach($costs as $cost)
				{
					++$counter;
					$cat_id = $cost['c_cat'];
					$type = $cost['c_type'];
					$time = prepare_time( $cost['c_time'] );
					$cat_name = $cats[$cat_id]["cc_name"];
					echo "<tr style='background-color:".cost_color($type).";' title='{$cost['c_id']}'>";
					echo "<td style='border: 1px solid blue;'> $time </td>";
					echo "<td style='border: 1px solid blue;'> ".cat_link($cat_name, $cat_id)." </td>";
					echo "<td style='border: 1px solid blue;'> {$cost['c_value']} </td>";
					echo "<td style='border: 1px solid blue;'> {$cost['c_desc']} </td>";
					echo "<td></td><td></td>";
					echo "</tr>";
					
					if ( $counter % 40 == 0 )
					{
						echo "</table></td><td> &nbsp; </td><td><table cellspacing='0' cellpadding='0'>";
					}
				}
				echo "</table>";
			?>	
			</td></tr></table>
		</td>
	</tr>
</table>