<?
// phpMyWebServices
/*
 This is the list of public WebServices...
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


// Now, you can add a line for each WebService you want to make appear on the index page...
// Those lines must look like that:
// MakePub("NameOfTheFolder");

MakePub("Test1");
MakePub("TestMySQL");
MakePub("ServiceThatDontExist");

?>