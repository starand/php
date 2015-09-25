<?
    if( isset($_POST['goal']) && isset($_POST['desc']) )
    {
        if ( empty($_POST['goal']) || empty($_POST['desc']) )
        {
            exit( "Goal or description cannot be empty!" );
        }
        
        include_once "db.php";
        if ( add_goal( $_POST['goal'], $_POST['desc'] ) )
        {
            echo( "Goal <b>{$_POST['goal']}</b> successfully added" );
        }
        
    }
?>

<form action='' method='post'>
Goal: <input type='text' name='goal'><br>
Desc: <input type='text' name='desc'><br>
<input type='submit'>
</form>
