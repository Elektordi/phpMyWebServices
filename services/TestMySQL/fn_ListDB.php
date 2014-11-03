<?
// Security block, do not edit...
if ( !defined('PHP_MY_WEB_SERVICES_FRAMEWORK_RUNTIME') )
{
	header("HTTP/1.1 403 FORBIDDEN");
	die();
}
// End of security block...

connect();

$r = mysql_query("SHOW DATABASES");

$return="";

while($line=mysql_fetch_row($r))
{
	$return .= $line[0].", ";
}

$WS_RETURN = trim($return,", ");

?>