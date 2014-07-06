<?
	include_once "utils/common.php";
	include_once UTILS."users.php";

	ApplyCSS();
	PerformUserCheck();
?>
<script src='misc/jquery.js'></script>
<div id=''content'><center>
<?
	if( !GetIsMobile() )
	{
		echo "<a href='#' class='title'>Light Control</a>";
	}

	echo "<div id='buttonsContainer'>";
		include_once "lightControl.php"; 
	echo "</div>";

	ShowMusicButtons();
	echo "<div id='musicPlayer'>";
		include_once "musicPlayer.php";
	echo "</div>";
?>
</div>
