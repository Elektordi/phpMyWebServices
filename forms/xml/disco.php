<? if ( !defined('PHP_MY_WEB_SERVICES_FRAMEWORK_RUNTIME') )
{
	header("HTTP/1.1 403 FORBIDDEN");
	die();
}
?>
<discovery xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns="http://schemas.xmlsoap.org/disco/">
  <contractRef ref="<? echo $ref; ?>?wsdl" docRef="<? echo $ref; ?>" xmlns="http://schemas.xmlsoap.org/disco/scl/" />
  <soap address="<? echo $ref; ?>" xmlns:q1="<? echo $uri; ?>" binding="q1:<? echo $wsc; ?>Soap" xmlns="http://schemas.xmlsoap.org/disco/soap/" />
</discovery>