<?
	if( !defined('SMART_HOUSE') ) die();
	
function CheckUser()
{
	global $gLoginPassword;
	return ( isset($_SESSION['smh_sd']) && isset($_SESSION['smh_sd']['login_pw']) && $_SESSION['smh_sd']['login_pw'] === $gLoginPassword );
}

function Login( $password )
{
	global $gLoginPassword;
	if( $password === $gLoginPassword ) {
		$_SESSION['smh_sd']['login_pw'] = $gLoginPassword;
	}
	return $_SESSION['smh_sd']['login_pw'] === $gLoginPassword;
}

function Logout()
{
	unset( $_SESSION['smh_sd']['login_pw'] );
}

function PerformUserCheck()
{
	if (isset($_POST['smh_pswd'])) Login( $_POST['smh_pswd'] );
	else
	{
		if (isset($_SESSION["n_user"]) && $_SESSION["n_user"]["uNick"] === "StarAnd")
		{
			global $gLoginPassword;
			$_SESSION['smh_sd']['login_pw'] = $gLoginPassword;
		}
	}

	if( !CheckUser() )
	{
		include_once UTILS."login_dlg.php";
		die();
	}
}
	
?>