<? 
	include_once "utils/common.php"; 
	include_once UTILS."users.php";
	ApplyCSS();
	PerformUserCheck();
?>
<script src='misc/jquery.js'></script>

<div id=''content'><center>

<? if( !GetIsMobile() ) { ?><h1>Smart House v1.0</h1><? } ?>
	
	<div id='buttonsContainer'>
	<? 
		include_once "lightControl.php"; 
	?>
	</div>
</div>
