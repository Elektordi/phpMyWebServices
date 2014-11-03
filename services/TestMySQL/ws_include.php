<?
// Security block, do not edit...
if ( !defined('PHP_MY_WEB_SERVICES_FRAMEWORK_RUNTIME') )
{
	header("HTTP/1.1 403 FORBIDDEN");
	die();
}
// End of security block...

// This PHP script is included before each fn_ call !
// It's a good place to write common php functions !

if(!isset($WS_LOGIN)) $WS_LOGIN="root";
if(!isset($WS_PASSWORD)) $WS_PASSWORD="";
if($WS_LOGIN=="") $WS_LOGIN="root";

function connect() {
	global $WS_LOGIN,$WS_PASSWORD;
	mysql_connect("localhost",$WS_LOGIN,$WS_PASSWORD);
}

// This var will be eval at the end of the fn_ call !

$WS_ENDCALL = "mysql_close();";

?>