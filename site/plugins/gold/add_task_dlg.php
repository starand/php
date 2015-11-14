<?
	if ( $_SESSION["n_user"]["uNick"] != "StarAnd" ) die();
	
    if( isset($_POST['task']) && isset($_POST['desc']) )
    {
        if ( empty($_POST['task']) || empty($_POST['desc']) )
        {
            exit( "Task or description cannot be empty!" );
        }
        
        include_once "db.php";
        if ( add_task( $_POST['task'], $_POST['desc'] ) )
        {
            echo( "Task <b>{$_POST['task']}</b> successfully added" );
        }
        
    }
?>

<form action='' method='post'>
Task: <input type='text' name='task'><br>
Desc: <input type='text' name='desc'><br>
<input type='submit'>
</form>