<?
## Socket Class by starand 18.08.2013
class CSocket
{	
	function __construct() 
	{
		if( !($this->socket_handler = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)) )
		{
			echo( "Unable to create socket" );
		}
	}
	
	public function Connect( $port, $address = "127.0.0.1" )
	{
		if( !@socket_connect($this->socket_handler, $address, $port) )
		{
			echo( "Unable to connect to $address:$port" );
			return false;
		}
		return true;
	}
	
	public function Send( $msg )
	{
		if( !socket_write($this->socket_handler, $msg, strlen($msg)) )
		{
			echo( "Unable to send data to $address:$port" );
			return false;
		}
		return true;
	}
	
	public function Recv( &$data, &$len )
	{
		if( !($len = socket_recv($this->socket_handler, $data, 2048, MSG_WAITALL)) )
		{
			echo( "Unable to recv data from $address:$port" );
			return false;
		}
		
		return true;
	}
	
	private $socket_handler;
};

?>