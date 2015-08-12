<?
function my_session_start()
{
      $sn = session_name();
      if (isset($_COOKIE[$sn])) {
          $sessid = $_COOKIE[$sn];
      } else if (isset($_GET[$sn])) {
          $sessid = $_GET[$sn];
      } else {
          return session_start();
      }

     if (!preg_match('/^[a-zA-Z0-9,\-]{22,40}$/', $sessid)) {
          return false;
      }
      return session_start();
}

if ( !my_session_start() ) {
    session_id( uniqid() );
    session_start();
    session_regenerate_id();
}

	header('Content-Type: text/html; charset=windows-1251');
	
	define ("COMMON", 1);
	
	include_once "db.php"; // connecting to db

	$REMOTE_ADDR = getenv('REMOTE_ADDR');
	
	// turn off error reporting
	if($REMOTE_ADDR !== "127.0.0.1") error_reporting(0);
	
	include_once ROOT_PATH."/users/users.php";
	$_USER = CheckUser();
	
## hightling code for languages:
	$langs = Array('Asm', 'Bash','Cpp','Delphi','Perl','Php','Python','Sql','Vb','Xml');
	
	
//********** DEBUG FUNCTION **********	
//	$MySQLquery=0;	$LoadTime = getmicrotime(); // debug information
## Return time to load and count of MySQL query;

// Creating global variables
//foreach($_GET as $key=>$value) { $$key = $value; } 
//foreach($_POST as $key=>$value) { $$key = $value; } 


function GetLoadTime() {
	global $LoadTime;
	$LoadTime = getmicrotime() - $LoadTime;
	return $LoadTime;
}
## get micro time
function getmicrotime() { 
   list($usec, $sec) = explode(" ", microtime()); 
   return ((float)$usec + (float)$sec); 
}
##  add new style
function AddStyle($name, $prefix)
{
	$query = "INSERT INTO styles (stName,stPrefix) VALUES('$name','$prefix')";
	return uquery($query);
}
## return style from DB
function GetStyle($id)
{
	$query = "SELECT * FROM styles WHERE stId=$id";
	$res = uquery($query);
	if($res && mysql_num_rows($res)) return mysql_fetch_array($res);
	else return 0;
}
function SetStyle($uid,$style)
{
	$query = "UPDATE users SET uStyle=$style where uId=$uid";
	return uquery($query);
}
## return list of style
function GetStyles()
{
	$query = "SELECT * FROM styles";
	$res = uquery($query);
	for($result=array();$row=mysql_fetch_array($res);$result[]=$row);
	return $result;
}
## return style from session
function style()
{
	global $path;
	if(isset($_SESSION['n_style'])) return "$path/themes/".$_SESSION['n_style']."/";
	else return "$path/themes/green/";	
}
## redirect to other page
function redirect($page)
{
	echo "<script>document.location.href='$page';</script>";
}
## send message or redirect
function EchoErrorMsg($msg="", $page="../files/main.php", $target="main", $method="post") {
	
	if($msg !== "") $msg = "?msg=$msg";
	echo "<script>document.location.href='$page$msg';</script>";
	die();
}
## delete XSS ijections symbols
function DelXSS(&$text) {
	$text = str_replace("'","`",$text);	$text = str_replace('"',"&quot;",$text);
	$text = str_replace("<","",$text);	$text = str_replace(">","",$text);
	return $text;
}
## return menu in string
function Menu()
{
	$user = CheckUser();

}
## return format date from mysql format
function fDate($date)
{
	return substr($date,11,5)." ".substr($date,8,2).".".substr($date,5,2).".".substr($date,0,4);
}
function Redirect1($url)
{
	header('Location:$url');
}

function AddPage($page,$path, $pType=0)
{
	$query = "insert ignore into pages (pPage, pPath,pType) values('$page','$path',$pType)";
	return uquery($query);
}
function GetPage($pPage)
{
	$query = "select * from pages where pPage='$pPage' limit 1";
	$res = uquery($query);
	if(mysql_num_rows($res)) return mysql_fetch_array($res);
	else return 0;
}
function GetPageById($id)
{
	$query = "select * from pages where pId=$id limit 1";
	$res = uquery($query);
	if(mysql_num_rows($res)) return mysql_fetch_array($res);
	else return 0;
}
function GetPath($pPage)
{
	$query = "select pPath from pages where pPage='$pPage' limit 1";
	$res = uquery($query);
	if(mysql_num_rows($res)) return mysql_result($res,0,0);
	else return 0;
}
## function conver MySQL formated date to user format
function sGetFDate($date) 
{
	$res = substr($date,11,5)." ".substr($date,5,2).".".substr($date,8,2);
	return $res;
}
## function conver MySQL formated date to user format
function sGetFDateWithYear($date) 
{
	$res = substr($date,11,5)." ".substr($date,5,2).".".substr($date,8,2).".".substr($date,0,4);
	return $res;
}
## delete begin & end quotes
function DelQuotes(&$str)
{
	trim($str);
	if( $str[0] == '"' || $str[0] == "'" ) $str = substr($str, 1);
	$endPos = strlen($str) - 2;
	if( $str[$endPos] == '"' || $str[$endPos] == "'" ) $str = substr($str, 0, $endPos);
	return $str;
}

##
function GetRandomBook()
{
	$sql = "select count(1) from books";
	$res = uquery( $sql );
	if( !mysql_num_rows($res) ) return 0;
	
	$count = mysql_result( $res, 0, 0 );
	$rndBook = rand( 0, --$count );
	
	$sql = "SELECT * FROM books LIMIT $rndBook, 1";
	$res = uquery( $sql );
	if( !mysql_num_rows($res) ) return 0;
	
	return mysql_fetch_array( $res );
}

##
function AddReminder( $uid, $text )
{
	DelXSS( $text );
	$sql = "INSERT INTO reminders VALUES(NULL, '$text', $uid, now())";
	return uquery( $sql );
}

function GetUserReminders( $uid, $limit )
{
	$sql = "SELECT * FROM reminders WHERE rUid=$uid LIMIT $limit";
	$res = uquery( $sql );
	if( !mysql_num_rows($res) ) return 0;
	for($result=array();$row=mysql_fetch_array($res);$result[]=$row);
	return $result;
}

function DeleteReminder( $uid, $rid )
{
	$sql = "DELETE FROM reminders WHERE rUid=$uid AND rId=$rid";
	return uquery( $sql );
}

function ShowPrompt( $right = "" )
{
	global $user;
	echo "<b style='font-size:12px;color:#00FF00;'>{$user['uNick']}<span style='color:#0000FF;'>@</span>$REMOTE_ADDR</b> # ";
	echo "<span class='path'>";
	
	$link = "<a class='path' style='color:magenta;' href='/files/main.php?script=".$_SESSION['script']."'>/".$_SESSION['script']."/";
	
	if($_SESSION['script']==="showforum" || $_SESSION['script']==="showmsg") 
		$link = "<a style='color:magenta;' class=path href='/files/main.php?script=forums'>/forums/";
	if($_SESSION['script']==="chapters" || $_SESSION['script']==="showart") 
		$link = "<a style='color:magenta;' class=path href='/files/main.php?script=articles'>/articles/";
		
	echo $link.$right;
	echo "</a></span>";
}

##
function AddJarvisMessage( $msg, $title="Safety Lab", $level = 1 )
{
    $config = GetConfig();
    if ($config['jarvis'])
    {
        $sql = "INSERT INTO jarvis.notifications VALUES( NULL, '$msg', '$title', $level, now() )";
        return uquery( $sql );
    }
}

function LoadConfigOptions($uid = 0)
{
    $sql = "SELECT * FROM config WHERE cfgUid=$uid";
	$res = uquery($sql);
	if (!mysql_num_rows($res)) return array();
	for($result=array();$row=mysql_fetch_array($res);$result[$row['cfgKey']] = $row['cfgValue']);
    $_SESSION['config'] = $result;
	return $result;
}

function UpdateConfig($key, $value)
{
    $sql = "UPDATE config SET cfgValue='$value' WHERE cfgKey='$key'";
    return uquery($sql);
}

function AddConfig($key, $value)
{
    $sql = "INSERT INTO config VALUES(NULL, '$key', '$value')";
    return uquery($sql);
}

function LoadConfig()
{
    global $user;
    $config = LoadConfigOptions();
    $userConfig = LoadConfigOptions($user['uId']);

    foreach ($userConfig as $k => $v)
    {
        $config[$k] = $v;
    }

    return $config;
}

function GetConfig()
{
    // if (isset($_SESSION['config'])) return $_SESSION['config'];
    // else
        return LoadConfig();
}

?>
