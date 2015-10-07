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
    $sql = "INSERT INTO goals VALUES( NULL, '$name', '$desc' )";
    return uquery($sql);
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
    $sql = "INSERT INTO tasks VALUES( NULL, '$name', '$desc' )";
    return uquery($sql);
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
    $query = "SELECT * FROM efforts ORDER BY e_id DESC LIMIT $count";
    $res = uquery($query);
	for($result=array(); $row=mysql_fetch_array($res); $result[$row['e_task_id']]=$row);
	return $result;
}

function add_effort($tid, $time, $comment)
{
    $query = "INSERT INTO efforts VALUES( NULL, $tid, $time, now(), '$comment' )";
    return uquery($query);
}

//-------------------------------------------------------------------------------------------------
// relations





} // multiply use
?>