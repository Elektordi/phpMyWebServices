<? 
// Security block, do not edit...
if ( !defined('PHP_MY_WEB_SERVICES_FRAMEWORK_RUNTIME') )
{
	header("HTTP/1.1 403 FORBIDDEN");
	die();
}
// End of security block...

// This file contents the auth system for your webservice.
// The login is in the $WS_LOGIN var and password in the $WS_PASSWORD var !
// To accept those informations, use: $WS_AUTHOK = true;
// In case of anonymous connection, both var are equal to ""

if($WS_LOGIN!="")
{
	$c = @mysql_connect("localhost",$WS_LOGIN,$WS_PASSWORD);
	if($c!="")
	{
		$WS_AUTHOK=true;
		mysql_close($c);
	}
}

?>