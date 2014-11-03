<? if ( !defined('PHP_MY_WEB_SERVICES_FRAMEWORK_RUNTIME') )
{
	header("HTTP/1.1 403 FORBIDDEN");
	die();
}
$i = 1;
?>
<discovery xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns="http://schemas.xmlsoap.org/disco/">
<?	function MakePub($ws)
	{
		global $i;
		$i++;
		if(!is_dir("services/".$ws)) return;
		include("services/".$ws."/ws_conf.php");
		if($needauth==true) return;
		$ref = "http://".$_SERVER["HTTP_HOST"].":".$_SERVER["SERVER_PORT"].substr($_SERVER["REQUEST_URI"],0,strpos($_SERVER["REQUEST_URI"],"?"))."/".$ws.".asmx";
?>
  <contractRef ref="<? echo $ref; ?>?wsdl" docRef="<? echo $ref; ?>" xmlns="http://schemas.xmlsoap.org/disco/scl/" />
  <soap address="<? echo $ref; ?>" xmlns:q<? echo $i; ?>="<? echo $uri; ?>" binding="q<? echo $i; ?>:<? echo $ws; ?>Soap" xmlns="http://schemas.xmlsoap.org/disco/soap/" />
<?	}

	include("services/list.php");
?>
</discovery>