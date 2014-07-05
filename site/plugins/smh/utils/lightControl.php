<?
	if( !defined('SMART_HOUSE') ) die();
	
	include_once UTILS."socket.php";
	include_once UTILS."enums.php";
	
	$password = "test_password";
	
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
	
	$request = array();
	if (count($lights)) $request['light'] = $lights;
	$request['client'] = array('ip' => $_SERVER['REMOTE_ADDR'], 'tool' => 'site' );
	
	$packet['request'] = $request;
	$json_data = json_encode($packet);

	do
	{
		$clientSock = new CSocket();
		if( !$clientSock->Connect(7300) ) break;
		
		# perform authorization
		global $password;
		if( !$clientSock->Send($password) ) break;
		if( !$clientSock->Recv($status, $bytes) ) break;
		
		//echo $json_data;
		if( !$clientSock->Send($json_data) ) break;
		if( !$clientSock->Recv($response, $bytes) ) break;
		//echo $response;
	}
	while(false);
	
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