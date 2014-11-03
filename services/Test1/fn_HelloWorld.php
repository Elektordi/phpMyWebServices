<?
// Security block, do not edit...
if ( !defined('PHP_MY_WEB_SERVICES_FRAMEWORK_RUNTIME') )
{
	header("HTTP/1.1 403 FORBIDDEN");
	die();
}
// End of security block...

$n = $WS_PARAM["how_many_times"];

$retour="";

for($i=0;$i<$n;$i++)
{
	$retour.="Hello world !\n";
}

$WS_RETURN = $retour;

?>