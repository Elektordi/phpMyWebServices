<?

// This is the main page of the phpMyWebServices Framework...

define('PHP_MY_WEB_SERVICES_FRAMEWORK_RUNTIME', true);

include("includes/functions.php");

//phpinfo(); die();

switch(strtoupper($_SERVER["REQUEST_METHOD"]))
{
  case "GET":
  	include("includes/get.php");
	break;
  case "POST":
  	if(isset($_SERVER["HTTP_SOAPACTION"]))
	{
		if($_SERVER["CONTENT_TYPE"]!="text/xml; charset=utf-8") die("UNKNOW SOAP-POST CONTENT: ".$_SERVER["CONTENT_TYPE"]);
		include("includes/soap.php");
	}
	else
	{
		if($_SERVER["CONTENT_TYPE"]!="application/x-www-form-urlencoded") die("UNKNOW POST CONTENT: ".$_SERVER["CONTENT_TYPE"]);
	  	include("includes/post.php");
	}
	break;
  default:
  	die("UNKNOW METHOD: ".$_SERVER["REQUEST_METHOD"]);
}

?>