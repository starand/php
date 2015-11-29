<?
	if ( $_SESSION["n_user"]["uNick"] != "StarAnd" ) die();
	
    include_once "db.php";

    if( isset($_POST['c_cat']) && isset($_POST['c_val']) && isset($_POST['c_desc']) && isset($_POST['c_type']) && isset($_POST['c_time']) )
    {
        if ( empty($_POST['c_cat']) || empty($_POST['c_val']) || empty($_POST['c_desc']) && isset($_POST['c_type']) && isset($_POST['c_time']) )
        {
            exit( "Cost category, value, description, time or type cannot be empty!" );
        }

        if ( add_cost( (int)$_POST['c_cat'], (float)$_POST['c_val'], $_POST['c_desc'], (int)$_POST['c_type'], $_POST['c_time'] ) )
        {
            echo( "Cost <b>{$_POST['name']}</b> successfully added" );
        }
        
    }
?>

<form action='' method='post'>
Cat: <select name='c_cat'>
<?
    $cats = get_cost_categories();
    foreach( $cats as $cat )
    {
        echo "<option value='{$cat[cc_id]}'>{$cat[cc_name]}</option>";
    }
?></select><br>
Val: <input type='text' name='c_val'><br>
Desc: <input type='text' name='c_desc'><br>
Time: <input type='text' name='c_time' value='<?=date('Y-m-d H:i:s');?>'><br>
Type: <select name='c_type'>
    <option value='0'>Fluent</option>
    <option value='1'>Valuable</option>
    <option value='2'>Debt</option>
</select><br>
<input type='submit'>
</form>
