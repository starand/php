<? 
	session_start(); 
	if ( $_SESSION["n_user"]["uNick"] != "StarAnd" ) die();
?>

<a style='font-size:20px;' href='index.php?page=finance'> FINANCE </a> &nbsp; <a style='font-size:20px;' href='index.php?page=goals'> GOALS </a><BR>

<?
    

    if ( isset($_GET['page']))  
    {
        $_SESSION['page'] = $_GET['page'];
    }
    else if ( !isset($_SESSION['page']) )
    {
        $_SESSION['page'] = "";
    }
    
    #echo $_SESSION['page'];
    
    switch ($_SESSION['page'])
    {
    case "finance":
        include_once "finance.php";
        break;
    case "goals":
        include_once "goals.php";
        break;
    }
?>