<?
    if( isset($_POST['cc_name']) )
    {
        if ( empty($_POST['cc_name']) )
        {
            exit( "Cost category name cannot be empty!" );
        }
        
        include_once "db.php";
        if ( add_cost_category( $_POST['cc_name'] ) )
        {
            echo( "Cost category <b>{$_POST['cc_name']}</b> successfully added" );
        }
        
    }
?>

<form action='' method='post'>
Name: <input type='text' name='cc_name'><br>
<input type='submit'>
</form>