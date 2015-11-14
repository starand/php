<?
	if ( $_SESSION["n_user"]["uNick"] != "StarAnd" ) die();
	
    include_once "db.php";

    if( isset($_POST['task_id']) && isset($_POST['spent_time']) && isset($_POST['comment']) )
    {
        if ( empty($_POST['task_id']) || empty($_POST['spent_time']) )
        {
            exit( "Task id or description cannot be empty!" );
        }

        if ( add_effort( (int)$_POST['task_id'], (int)$_POST['spent_time'], $_POST['comment'] ) )
        {
            echo( "Effort for task id <b>{$_POST['task_id']}</b> successfully added" );
        }
        
    }
?>


<form action='' method='post'>
Task: <select name='task_id'>
<?
    $tasks = get_tasks();
    foreach( $tasks as $task)
    {
        echo "<option value='{$task[t_id]}'>{$task[t_name]}</option>";
    }
?></select><br>
Spent time: <input type='text' name='spent_time'><br>
Comment: <input type='text' name='comment'><br>
<input type='submit'>
</form>