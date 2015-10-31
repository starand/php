<?
    include_once "db.php";

    if( isset($_POST['i_cat']) && isset($_POST['i_val']) && isset($_POST['i_time']) )
    {
        if ( empty($_POST['i_cat']) || empty($_POST['i_val']) || empty($_POST['i_time']) )
        {
            exit( "Income category, time or value cannot be empty!" );
        }

        $cat = (int)$_POST['i_cat'];
        if ( add_income( $cat, (float)$_POST['i_val'], $_POST['i_time'] ) )
        {
            $cats = get_income_categories();
            echo( "Income <b>{$cats[$cat]['ic_name']}</b> successfully added" );
        }
        
    }
?>

<form action='' method='post'>
Cat: <select name='i_cat'>
<?
    $cats = get_income_categories();
    foreach( $cats as $cat)
    {
        echo "<option value='{$cat[ic_id]}'>{$cat[ic_name]}</option>";
    }
?></select><br>
Val: <input type='text' name='i_val'><br>
Time: <input type='text' name='i_time' value='<?=date('Y-m-d H:i:s');?>'><br>
<input type='submit'>
</form>