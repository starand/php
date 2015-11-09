<?
if(!defined("__DB__")) {
  
	define("__DB__", 1);
    
	include_once "config.php";
	
	// MySQL host
	$db_host = "localhost";	
	// MySQL user name
	$mysql_user = "stream"; 	
	// MySQL password
	$mysql_pswd = "hacker";

    # connecting
	@mysql_pconnect(db_host,mysql_user,mysql_pswd) or die("Can not connect to database!!"); 
	mysql_select_db(db_name) or die("Can not select database!!");


## send query to db	
function uquery($query) 
{
	$result = @mysql_query($query) or die("Can not send query to database!!");
	return $result;
}
## return path 
function path()
{
	global $path;
	return $path;
}

//-------------------------------------------------------------------------------------------------
// GOALS

function get_goals()
{
    $query = "SELECT * FROM goals";
	$res = uquery($query);
	for($result=array(); $row=mysql_fetch_array($res); $result[]=$row);
	return $result;
}

function add_goal($name, $desc)
{
    $query = "INSERT INTO goals VALUES( NULL, '$name', '$desc' )";
    return uquery($query);
}

//-------------------------------------------------------------------------------------------------
// TASKS

function get_tasks()
{
    $query = "SELECT * FROM tasks";
	$res = uquery($query);
	for($result=array(); $row=mysql_fetch_array($res); $result[$row['t_id']]=$row);
	return $result;
}

function get_tasks_for_goal($gid)
{
    $query = "SELECT t_id, t_name, t_desc FROM tasks, goals, tasks_to_goals WHERE g_id=$gid AND tg_goal_id=g_id AND tg_task_id=t_id";
	$res = uquery($query);
	for($result=array(); $row=mysql_fetch_array($res); $result[]=$row);
	return $result;
}

function get_task($id)
{
    $query = "SELECT * FROM tasks WHERE t_id=$id";
    return ($row = mysql_fetch_array(uquery($query))) ? $row : false;
}

function add_task($name, $desc)
{
    $query = "INSERT INTO tasks VALUES( NULL, '$name', '$desc' )";
    return uquery($query);
}

//-------------------------------------------------------------------------------------------------
// EFFORTS

function get_efforts()
{
    $query = "SELECT e_task_id, count(e_spent_time_m) FROM efforts GROUP by e_task_id";
    $res = uquery($query);
	for($result=array(); $row=mysql_fetch_array($res); $result[$row['e_task_id']]=$row);
	return $result;
}

function get_lastest_efforts($count = 20)
{
    $query = "SELECT * FROM efforts ORDER BY e_time DESC LIMIT $count";
    $res = uquery($query);
	for($result=array(); $row=mysql_fetch_array($res); $result[$row['e_id']]=$row);
	return $result;
}

function add_effort($tid, $time, $comment)
{
    $query = "INSERT INTO efforts VALUES( NULL, $tid, $time, now(), '$comment' )";
    return uquery($query);
}

//-------------------------------------------------------------------------------------------------
// COST CATEGORIES

function add_cost_category($name)
{
    $query = "INSERT INTO cost_cats VALUES(NULL, '$name')";
    return uquery($query);
}

function get_cost_categories()
{
    $query = "SELECT * FROM cost_cats";
    $res = uquery($query);
	for($result=array(); $row=mysql_fetch_array($res); $result[$row['cc_id']]=$row);
	return $result;
}

//-------------------------------------------------------------------------------------------------
// COSTS

function add_cost($cat, $val, $desc, $type=0, $time) // types: 0 - not val, 1 - val, 2 - debt
{
    $query = "INSERT INTO costs VALUES(NULL, $cat, '$time', $val, '$desc', $type)";
    return uquery($query);
}

function get_costs($limit = 30)
{
    $query = "SELECT * FROM costs ORDER BY c_id DESC LIMIT $limit";
    $res = uquery($query);
	for($result=array(); $row=mysql_fetch_array($res); $result[]=$row);
	return $result;
}

function get_costs_per_month($month, $year = 2015, $cat = 0)
{
	$time = "$year-$month-01";
	$cat_expr = $cat == 0 ? "" : " AND c_cat = $cat";
	$query = "SELECT * FROM costs ".
			 "WHERE UNIX_TIMESTAMP(c_time) >= UNIX_TIMESTAMP(LAST_DAY('$time') + INTERVAL 1 DAY - INTERVAL 1 MONTH) ".
				"AND UNIX_TIMESTAMP(c_time) < UNIX_TIMESTAMP(LAST_DAY('$time') + INTERVAL 1 DAY) ".
				"$cat_expr";
    $res = uquery($query);
	for($result=array(); $row=mysql_fetch_array($res); $result[]=$row);
	return $result;
}

function get_costs_sum($month, $year = 2015, $cat = 0)
{
	$time = "$year-$month-01";
	$cat_expr = $cat == 0 ? "" : " AND c_cat = $cat";
	$query = "SELECT sum(c_value) FROM costs ".
			 "WHERE UNIX_TIMESTAMP(c_time) >= UNIX_TIMESTAMP(LAST_DAY('$time') + INTERVAL 1 DAY - INTERVAL 1 MONTH) ".
				"AND UNIX_TIMESTAMP(c_time) < UNIX_TIMESTAMP(LAST_DAY('$time') + INTERVAL 1 DAY) ".
				"$cat_expr";
	$res = uquery($query);
	if ( $res && mysql_num_rows($res) ) return mysql_result($res, 0, 0);
	return 0;
}

function get_costs_by_cats($month, $year = 2015)
{
	$time = "$year-$month-01";
	$query = "SELECT sum(c_value)as sum, c_cat FROM costs ".
			 "WHERE UNIX_TIMESTAMP(c_time) >= UNIX_TIMESTAMP(LAST_DAY('$time') + INTERVAL 1 DAY - INTERVAL 1 MONTH) ".
				"AND UNIX_TIMESTAMP(c_time) < UNIX_TIMESTAMP(LAST_DAY('$time') + INTERVAL 1 DAY) ".
				"GROUP BY c_cat";
    $res = uquery($query);
	for($result=array(); $row=mysql_fetch_array($res); $result[$row['c_cat']]=$row['sum']);
	return $result;
}

//-------------------------------------------------------------------------------------------------
// INCOME CTEGORIES

function add_income_category($name)
{
    $query = "INSERT INTO income_cats VALUES(NULL, '$name')";
    return uquery($query);
}

function get_income_categories()
{
    $query = "SELECT * FROM  income_cats";
    $res = uquery($query);
	for($result=array(); $row=mysql_fetch_array($res); $result[$row['ic_id']]=$row);
	return $result;
}

//-------------------------------------------------------------------------------------------------
// INCOMES

function add_income($cat, $val, $time)
{
    $query = "INSERT INTO incomes VALUES(NULL, $cat, '$time', $val)";
    return uquery($query);
}

function get_incomes()
{
    $query = "SELECT * FROM incomes";
    $res = uquery($query);
	for($result=array(); $row=mysql_fetch_array($res); $result[]=$row);
	return $result;
}

function get_incomes_per_month($month, $year = 2015, $cat = 0)
{
	$time = "$year-$month-01";
	$cat_expr = $cat == 0 ? "" : " AND i_cat = $cat";
    $query = "SELECT * FROM incomes ".
			"WHERE UNIX_TIMESTAMP(i_time) >= UNIX_TIMESTAMP(LAST_DAY('$time') + INTERVAL 1 DAY - INTERVAL 1 MONTH) ".
			"AND UNIX_TIMESTAMP(i_time) < UNIX_TIMESTAMP(LAST_DAY('$time') + INTERVAL 1 DAY) ".
			"$cat_expr";
			
    $res = uquery($query);
	for($result=array(); $row=mysql_fetch_array($res); $result[]=$row);
	return $result;
}

function get_incomes_sum($month, $year = 2015, $cat = 0)
{
	$time = "$year-$month-01";
	$cat_expr = $cat == 0 ? "" : " AND i_cat = $cat";
	$query = "SELECT sum(i_value) FROM incomes ".
			 "WHERE UNIX_TIMESTAMP(i_time) >= UNIX_TIMESTAMP(LAST_DAY('$time') + INTERVAL 1 DAY - INTERVAL 1 MONTH) ".
				"AND UNIX_TIMESTAMP(i_time) < UNIX_TIMESTAMP(LAST_DAY('$time') + INTERVAL 1 DAY) ".
				"$cat_expr";
	$res = uquery($query);
	if ( $res && mysql_num_rows($res) ) return mysql_result($res, 0, 0);
	return 0;
}

//-------------------------------------------------------------------------------------------------
// CONSTS

function add_const( $name, $val )
{
	$query = "INSERT INTO consts VALUES('$name', '$val')";
	return uquery( $query );
}

function get_consts( )
{
	$query = "SELECT * FROM consts";
	$res = uquery($query);
	for($result=array(); $row=mysql_fetch_array($res); $result[$row['cn_name']]=$row['cn_value']);
	return $result;
}


} // multiply use
?>