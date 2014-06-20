<?
	include_once "utils/common.php";
	include_once UTILS."lightControl.php";

	if( isset($_GET['command']) ) $command = (int)$_GET['command']; 
	elseif( isset($_POST['command']) ) $command = (int)$_POST['command']; 
	else $command = 10;

	do
	{
		$g_nStatus = ExecuteCommand( $command );
		if( !GetIsMobile() )
			ShowButtonsDefault( $g_nStatus );
		else 
			ShowButtonsMobile( $g_nStatus );
	}
	while( false );
?>
<script>
$(document).ready(function() 
{
	<?
		DeclareButtonHandler( "kitchenLightButton",	 EBUTTONBITS::EBB_KITCHEN,	CMD::KitchenLightOff,	CMD::KitchenLightOn );
		DeclareButtonHandler( "bathroomLightButton", EBUTTONBITS::EBB_BATHROOM,	CMD::BathroomLightOff,	CMD::BathroomLightOn );
		DeclareButtonHandler( "toiletLightButton",	 EBUTTONBITS::EBB_TOILET,	CMD::ToiletLightOff,	CMD::ToiletLightOn );
		DeclareButtonHandler( "corridorLightButton", EBUTTONBITS::EBB_CORRIDOR, CMD::CorridorLightOff,	CMD::CorridorLightOn );
		DeclareButtonHandler( "hallLightButton",	 EBUTTONBITS::EBB_HALL,		CMD::HallLightOff,		CMD::HallLightOn );
		DeclareButtonHandler( "nightLightButton",	 EBUTTONBITS::EBB_LAMP,		CMD::NightLightOff,		CMD::NightLightOn );
	?>
})

setTimeout( 'refresh();', 1000 );
function refresh() { $('#buttonsContainer').load( 'lightControl.php' ); }
</script>