<?
// phpMyWebServices
/*
 This is the definition file for this custom type...
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

$typename = "date"; // Put the same name as the ct_ file !
$servicename = "Test1"; // Put the WebServiceCode here (like in ws_conf) !


$var_num = 3; // Numbers of vars.

// Vars: (! First parameter is 0)
//$var_name[] = ""; // Var name
//$var_type[] = ""; // Var type

// Start of vars list

$var_name[0] = "day"; // Parameter name
$var_type[0] = "int"; // Parameter type

$var_name[1] = "mounth"; // Parameter name
$var_type[1] = "int"; // Parameter type

$var_name[2] = "year"; // Parameter name
$var_type[2] = "int"; // Parameter type

// End of vars list


// That's all for now...
?>