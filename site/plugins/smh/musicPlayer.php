<?
	include_once "utils/common.php";
	include_once UTILS."musicPlayer.php";
?>

<script>
$(document).ready(function() 
{
	<?
		DeclareMusicHandler('play', 1);
		DeclareMusicHandler('pause', 1);
		DeclareMusicHandler('forward', 3);
		DeclareMusicHandler('backward', 4);
		DeclareMusicHandler('volplus', 5);
		DeclareMusicHandler('volminus', 6);
		
	?>
})

//setTimeout( 'refreshMusicPlayer();', 1000 );
function refreshMusicPlayer() { 
	$('#musicPlayer').load( 'musicPlayer.php' );
}
</script>