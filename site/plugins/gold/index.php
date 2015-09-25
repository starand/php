<HEAD><LINK href='/themes/green/main.css' rel=stylesheet type=text/css>
<meta http-equiv='Content-Type' content='text/html; charset=windows-1251'></HEAD>
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