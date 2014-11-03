<?
// phpMyWebServices
/*
 This is the definition file for this WebService...
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

$wsc = "TestMySQL"; // This is the WebserviceCode... Set it like the forder name !

$uri = "http://phpmywebservice.sf.net"; // This is the namespace of this webservice. For more infos, read the microsoft webservices help or http://www.w3.org/TR/REC-xml-names/

$needauth = true; // This webservice need a login and a password...

// That's all for now...

/*
	About files in this folder:

 ws_conf.php -> This file. Without it, your webservice will not exist...
 ws_info.php -> A informations file... Put in simple HTML the description of your service ! Il you don't want to use this file, leave it blank but don't delete it !
 ws_include.php -> Call before each fn_ call...
 ws_auth.php -> Verify login and password...
 fn_[MethodName].php -> A fonction of your webservice... For more informations, take a look at the phpMyWebServices help or the sample service !
 op_[MethodName].php -> Must come with a fn_ file ! It explain to the framework the interfaces of your fonction...
 
 And, if you want, you can add files of your own but never start your others files names with "ws_", "fn_" or "op_" !!!
 
*/

?>