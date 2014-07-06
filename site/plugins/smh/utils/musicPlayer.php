<?
	if( !defined('SMART_HOUSE') ) die();
	
	include_once UTILS."socket.php";
	include_once UTILS."enums.php";
	
	$command = false;
	if (isset($_GET['command'])) $command = (int)$_GET['command']; 
	elseif (isset($_POST['command'])) $command = (int)$_POST['command'];
	
	if ($command)
	{
		$packet['request']['music']['command'] = $command;
		AddCommonInfo($packet);

		$response = '';
		makeRequest(json_encode($packet), $response);
		$result = json_decode($response);
		echo $result->response->music->track;
	}


function DeclareMusicHandler($name, $command)
{
	echo "$('#$name').click(function() { $('#musicPlayer').load('musicPlayer.php?command=$command'); });\n";
}



?>