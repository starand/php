<?
    if( isset($_POST['ic_name']) )
    {
        if ( empty($_POST['ic_name']) )
        {
            exit( "Income category name cannot be empty!" );
        }
        
        include_once "db.php";
        if ( add_income_category( $_POST['ic_name'] ) )
        {
            echo( "Income category <b>{$_POST['ic_name']}</b> successfully added" );
        }
        
    }
?>

<form action='' method='post'>
Name: <input type='text' name='ic_name'><br>
<input type='submit'>
</form>