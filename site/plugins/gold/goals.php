<HEAD><LINK href='/themes/green/main.css' rel=stylesheet type=text/css>
<meta http-equiv='Content-Type' content='text/html; charset=windows-1251'></HEAD>
<table>
<tr><td style='border: 1px solid blue;'>
<?
    include_once "db.php";
    
    $goals = get_goals();
    $efforts = get_efforts();
    echo "<table>";
    foreach( $goals as $goal )
    {
        echo "<tr><td style='color:#00FFBF;'><b >{$goal['g_name']}</b></td>";
        echo "<td>{$goal['g_desc']}</td></tr>";
        echo "<tr><td colspan='2'>";
        
        echo "<table>";
        $tasks = get_tasks_for_goal($goal['g_id']);
        foreach( $tasks as $task )
        {
            $total = $efforts[$task['t_id']][1] ? $efforts[$task['t_id']][1] : 0;
            echo "<tr><td> [ {$total} ]</td><td><b style='color:magenta;'>{$task['t_name']}</b> -- {$task['t_desc']}</td></tr>";
        }
        
        echo "</table>";
        echo "</td></tr>";
    }
    echo "</table>";
?>
</td><td>  </td><td style='vertical-align:middle;text-align:center;'>

<table style='border: 1px solid blue;'>
<?
    $tasks = get_tasks();
    $last_efforts = get_lastest_efforts();
    
    foreach( $last_efforts as $effort )
    {
        echo "<tr><td>[{$effort['e_time']}] </td><td style='color:magenta;'> {$tasks[$effort['e_task_id']]['t_name']} </td>";
        echo "<td> {$effort['e_spent_time_m']} </td><td style='color:white;'> {$effort['e_comment']} </td></tr>";
    }
?>
</table>

<BR>

<h1>GOLD</h1>
<table cellspacing=5 cellpadding=10>
    <tr>
		<td style='border: 1px solid blue;'><h2>Add Effort</h2><? include_once "add_effort_dlg.php"; ?></td>
		<td style='border: 1px solid blue;'><h2>Add Task</h2><? include_once "add_task_dlg.php"; ?></td>
		<td style='border: 1px solid blue;'><h2>Add Goal</h2><? include_once "add_goal_dlg.php"; ?></td>
	</tr>
</table>

</td></tr>
</table>
