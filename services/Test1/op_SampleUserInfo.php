<?
// phpMyWebServices
/*
 This is the definition file for this fonction...
 Read this file and make changes like comments explain it !
 DO NOT MODIFY THE VAR. NAMES IF YOU WANT TO KEEP THEM WORKING !!!
*/

// Security block, do not edit...
if ( !defined('PHP_MY_WEB_SERVICES_FRAMEWORK_RUNTIME') )
{
	header("HTTP/1.1 403 FORBIDDEN");
	die();
}
// End of security block...

$functionname = "SampleUserInfo"; // Put the same name as the fn_ and op_ files !
$servicename = "Test1"; // Put the WebServiceCode here (like in ws_conf) !

$returntype = "_user";	// The type of the return... Take a look at the help for type list... Custom types not supported yet !

$args_num = 2; // Numbers of parameters. 0=No parameters

// Parameters: (! First parameter is 0)
//$args_name[] = ""; // Parameter name
//$args_type[] = ""; // Parameter type

// Start of parameters list

$args_name[0] = "name"; // Parameter name
$args_type[0] = "string"; // Parameter type

$args_name[1] = "birth"; // Parameter name
$args_type[1] = "_date"; // Parameter type

// End of parameters list


// That's all for now...
?>