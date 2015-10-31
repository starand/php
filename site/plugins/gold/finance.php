<HEAD><LINK href='/themes/green/main.css' rel=stylesheet type=text/css>
<meta http-equiv='Content-Type' content='text/html; charset=windows-1251'></HEAD>

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
	
	if ( $months >= $month )
	{
		$month = 13 - months;
		$year -= 1;
	}
	else
	{
		$month -= $months;
	}

	$time = "$month.$year";
	$time_url = str_replace(".", "&year=", $time);
	
	return "<a href='?month=$time_url'>$time</a>";
}

#################################################################
## Global Vars

	$month = isset($_GET['month']) ? (int)$_GET['month'] : date('m');
	$year = isset($_GET['year']) ? (int)$_GET['year'] : date('Y');
	$category = isset($_GET['cat']) ? (int)$_GET['cat'] : 0;
	
	include_once "db.php";
?>

<h1>Finance</h1>
<?
	echo get_prev_month_url(0)." | ".get_prev_month_url(1)." | ".get_prev_month_url(2);
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
							$income_total = get_incomes_sum($month, $year, $category);
							echo "<h2>Incomes</h2>Total: $income_total";
							$cats = get_income_categories();
							$incomes = get_incomes_per_month($month, $year, $category);
							
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
						?>
							
							<tr><td>
							</td></tr>
						
					</td>
				</tr>
			</table>
		</td>
		<td rowspan='3' style='border: 1px solid blue;'>
			<?
				$cost_total = get_costs_sum($month, $year, $category);
				echo "<h2>Costs</h2>Total: $cost_total, Net profit: ".($income_total - $cost_total);
			?>
			<table cellspacing='0' cellpadding='0'><tr><td>
			<?
				$costs = get_costs_per_month($month, $year, $category);
				$cats = get_cost_categories();
				
				$counter = 0;
				echo "<table cellspacing='0' cellpadding='0'>";
				foreach($costs as $cost)
				{
					++$counter;
					$cat_id = $cost['c_cat'];
					$time = prepare_time( $cost['c_time'] );
					$cat_name = $cats[$cat_id]["cc_name"];
					echo "<tr style='background-color:".cat_color($cat_id).";' title='{$cost['c_id']}'>";
					echo "<td style='border: 1px solid blue;'> $time </td>";
					echo "<td style='border: 1px solid blue;'> $cat_name </td>";
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