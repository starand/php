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
	$onLights = array();
	$offLights = array();
	
	switch($command)
	{
		case CMD::KitchenLightOn:	$onLights[] = EROOMS::KITCHEN; break;
		case CMD::KitchenLightOff:	$offLights[] = EROOMS::KITCHEN; break;
		case CMD::BathroomLightOn:	$onLights[] = EROOMS::BATHROOM; break;
		case CMD::BathroomLightOff:	$offLights[] = EROOMS::BATHROOM; break;
		case CMD::ToiletLightOn:	$onLights[] = EROOMS::TOILET; break;
		case CMD::ToiletLightOff:	$offLights[] = EROOMS::TOILET; break;
		case CMD::CorridorLightOn:	$onLights[] = EROOMS::CORRIDOR; break;
		case CMD::CorridorLightOff:	$offLights[] = EROOMS::CORRIDOR; break;
		case CMD::HallLightOn:		$onLights[] = EROOMS::HALL; break;
		case CMD::HallLightOff:		$offLights[] = EROOMS::HALL; break;
		case CMD::NightLightOn:		$onLights[] = EROOMS::LAMP; break;
		case CMD::NightLightOff:	$offLights[] = EROOMS::LAMP; break;
	}
	
	$lights = array();
	if (count($onLights)) { $lights['on'] = $onLights; }
	if (count($offLights)) { $lights['off'] = $offLights; }
	if (count($lights)) $packet['request']['light'] = $lights;
	
	AddCommonInfo($packet);
	
	$json_data = json_encode($packet);

	$response = '';
	makeRequest($json_data, $response);
	
	$status = 0;
	$result = json_decode($response);
	if (isset($result->response->light_status))
	{
		$status = $result->response->light_status;
	}

	return (int)$status;
}

function ShowButton( $name, $state, $strId)
{
	echo "<td style='width:100px;'>";
		echo "<a id='$strId' href='#' class='".($state ? "buttonOn" : "buttonOff")."'
				style='width:130px;line-height:65px;vertical-align:middle;'>$name</a>";
	echo "</td>";
}

function ShowButtonsDefault( $g_nStatus )
{
	echo "<table class='buttonTable'>";
	echo "<tr>";
		ShowButton( "Кухня", 	$g_nStatus & EBUTTONBITS::EBB_KITCHEN, 	"kitchenLightButton" );
		ShowButton( "Лампа", 	$g_nStatus & EBUTTONBITS::EBB_LAMP, 	"nightLightButton" );
	echo "</tr><tr>";
		ShowButton( "Ванна", 	$g_nStatus & EBUTTONBITS::EBB_BATHROOM, "bathroomLightButton" );
		ShowButton( "Туалет", 	$g_nStatus & EBUTTONBITS::EBB_TOILET, 	"toiletLightButton" );
	echo "</tr><tr>";
		ShowButton( "Коридор", 	$g_nStatus & EBUTTONBITS::EBB_CORRIDOR, "corridorLightButton" );
		ShowButton( "Зал", 		$g_nStatus & EBUTTONBITS::EBB_HALL, 	"hallLightButton" );
	echo "</tr></table>";
}


function ShowButtonMobile( $name, $state, $command )
{
	echo "<a href='index.php?command=$command' class='".($state ? "buttonOn" : "buttonOff")."' style='width:112px;line-height:53px;vertical-align:middle;'>$name</a> ";
}
	
function ShowButtonsMobile( $g_nStatus )
{
	echo "<table class='buttonTable' style='width:230px;'>";
	echo "<tr><td>";
		ShowButtonMobile( "Кухня", 	$g_nStatus & EBUTTONBITS::EBB_KITCHEN, $g_nStatus & EBUTTONBITS::EBB_KITCHEN ? CMD::KitchenLightOff : CMD::KitchenLightOn );
		ShowButtonMobile( "Лампа", 	$g_nStatus & EBUTTONBITS::EBB_LAMP, $g_nStatus & EBUTTONBITS::EBB_LAMP ? CMD::NightLightOff : CMD::NightLightOn);
	echo "</td></tr><tr><td>";	
		ShowButtonMobile( "Ванна", 	$g_nStatus & EBUTTONBITS::EBB_BATHROOM, $g_nStatus & EBUTTONBITS::EBB_BATHROOM ? CMD::BathroomLightOff : CMD::BathroomLightOn );
		ShowButtonMobile( "Туалет", 	$g_nStatus & EBUTTONBITS::EBB_TOILET, $g_nStatus & EBUTTONBITS::EBB_TOILET ? CMD::ToiletLightOff : CMD::ToiletLightOn );
	echo "</td></tr><tr><td>";
		ShowButtonMobile( "Коридор", $g_nStatus & EBUTTONBITS::EBB_CORRIDOR, $g_nStatus & EBUTTONBITS::EBB_CORRIDOR ? CMD::CorridorLightOff : CMD::CorridorLightOn );
		ShowButtonMobile( "Зал", 	$g_nStatus & EBUTTONBITS::EBB_HALL, $g_nStatus & EBUTTONBITS::EBB_HALL ? CMD::HallLightOff : CMD::HallLightOn );
		
	echo "</td></tr></table>";	
}
?>