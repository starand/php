<?
	if( !defined('SMART_HOUSE') ) die();
	
	include_once UTILS."socket.php";
	include_once UTILS."enums.php";
	
function IsRoomLight( $room )
{
	global $g_nStatus;
	return $g_nStatus & $room;
}

function GetRoomNextCommand($room, $onCmd, $offCmd)
{
	return IsRoomLight($room) ? $onCmd : $offCmd;
}
	
function RunCommand( $command )
{
	global $clientSock;
	$command .= ":site:".$_SERVER['REMOTE_ADDR'];	
	return $clientSock->Send( $command );
}

function DeclareButtonHandler( $name, $room, $onCmd, $offCmd)
{
	echo "$('#$name').click(function() { $('#buttonsContainer').load( 'lightControl.php?command=".GetRoomNextCommand($room, $onCmd, $offCmd)."' ); });\n";
}

function ExecuteCommand( $command )
{
	do
	{
		$clientSock = new CSocket();
		$command .= ":site:".$_SERVER['REMOTE_ADDR'];
		
		if( !$clientSock->Connect(7300) ) break;
		if( !$clientSock->Send($command) ) break;
		if( !$clientSock->Recv($data, $bytes) ) break;
	}
	while(false);
	
	return (int)$data;
}

function ShowButton( $name, $state, $strId)
{
	echo "<td style='text-align:center;'>$name</td><td style='width:100px;'>";
		echo "<img id='$strId' src='".($state ? "img/onBtn.jpg" : "img/offBtn.jpg")."' >";
	echo "</td>";
}

function ShowButtonsDefault( $g_nStatus )
{
	echo "<table style='background:#191F2F;color:#BF40FF;font-weight:bold;font-family:verdana;padding:10px;width:350px;'>";
	echo "<tr>";
		ShowButton( "Кухня", 	$g_nStatus & EBUTTONBITS::EBB_KITCHEN, 	"kitchenLightButton" );
		ShowButton( "Ванна", 	$g_nStatus & EBUTTONBITS::EBB_BATHROOM, "bathroomLightButton" );
		ShowButton( "Туалет", 	$g_nStatus & EBUTTONBITS::EBB_TOILET, 	"toiletLightButton" );
	echo "</tr><tr>";
		ShowButton( "Коридор", 	$g_nStatus & EBUTTONBITS::EBB_CORRIDOR, "corridorLightButton" );
		ShowButton( "Зал", 		$g_nStatus & EBUTTONBITS::EBB_HALL, 	"hallLightButton" );
		ShowButton( "Лампа", 	$g_nStatus & EBUTTONBITS::EBB_LAMP, 	"nightLightButton" );
	echo "</tr></table>";
}

function ShowButtonMobile( $name, $state, $command )
{
	echo "<td>$name</td><td><a href='index.php?command=$command'><img id='$strId' src='".($state ? "img/onBtn.jpg" : "img/offBtn.jpg")."' ></a></td>\n";
}
	
function ShowButtonsMobile( $g_nStatus )
{
	echo "<table style='background:#191F2F;color:#BF40FF;font-weight:bold;font-family:verdana;padding:10px;width:350px;'>";
	echo "<tr>";
		ShowButtonMobile( "Кухня", 	$g_nStatus & EBUTTONBITS::EBB_KITCHEN, $g_nStatus & EBUTTONBITS::EBB_KITCHEN ? CMD::KitchenLightOff : CMD::KitchenLightOn );
		ShowButtonMobile( "Ванна", 	$g_nStatus & EBUTTONBITS::EBB_BATHROOM, $g_nStatus & EBUTTONBITS::EBB_BATHROOM ? CMD::BathroomLightOff : CMD::BathroomLightOn );
		ShowButtonMobile( "Туалет", 	$g_nStatus & EBUTTONBITS::EBB_TOILET, $g_nStatus & EBUTTONBITS::EBB_TOILET ? CMD::ToiletLightOff : CMD::ToiletLightOn );
	echo "</tr><tr>";
		ShowButtonMobile( "Коридор", $g_nStatus & EBUTTONBITS::EBB_CORRIDOR, $g_nStatus & EBUTTONBITS::EBB_CORRIDOR ? CMD::CorridorLightOff : CMD::CorridorLightOn );
		ShowButtonMobile( "Зал", 	$g_nStatus & EBUTTONBITS::EBB_HALL, $g_nStatus & EBUTTONBITS::EBB_HALL ? CMD::HallLightOff : CMD::HallLightOn );
		ShowButtonMobile( "Лампа", 	$g_nStatus & EBUTTONBITS::EBB_LAMP, $g_nStatus & EBUTTONBITS::EBB_LAMP ? CMD::NightLightOff : CMD::NightLightOn);
	echo "</tr></table>";	
}
?>