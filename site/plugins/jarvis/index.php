<?
	include_once ".hide/config.php";
	include_once ROOT."system/mysql.php";
	include_once ROOT."system/modules.php";
	
	$module = 'main';
	if( isset($_GET['module']) ) $module = $_GET['module'];
	if( $modulePath = GetModulePath($module) ) 
	{
		include_once ROOT.$modulePath;
	}

?>