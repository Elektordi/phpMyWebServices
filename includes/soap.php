<?
if ( !defined('PHP_MY_WEB_SERVICES_FRAMEWORK_RUNTIME') )
{
	header("HTTP/1.1 403 FORBIDDEN");
	die();
}

$ws = rtrim(ltrim($_SERVER["PATH_INFO"],"/"),".asmx");
$fn = trim($_SERVER["HTTP_SOAPACTION"],"\"");
$fn = substr($fn,strrpos($fn,"/")+1);

loadws($ws);
loadfn($fn,$ws);

$data=$HTTP_RAW_POST_DATA;

$WS_PARAM["_PHP_MWS_"]="phpMyWebServices v".$WS_VER;
$WS_PARAM["_WS_"]=$ws;
$WS_PARAM["_FN_"]=$fn;
$WS_PARAM["_RT_"]=$returntype;
$WS_PARAM["_NS_"]=$uri;

if($args_num>0) {
	for($i=0;$i<$args_num;$i++) {
		if(strpos($data,"<".$args_name[$i].">")===false) die($args_name[$i].": not found");
		if(strpos($data,"</".$args_name[$i].">")===false) die($args_name[$i].": /not found");
		$len = strlen($args_name[$i]);
		$pos = strpos($data,"<".$args_name[$i].">")+$len+2;
		$par = substr($data,$pos,strpos($data,"</".$args_name[$i].">")-$pos);
		if(substr($args_type[$i],0,1)=="_") $WS_PARAM[$args_name[$i]]=WS_CTDECODE(substr($args_type[$i],1),$par);
			else $WS_PARAM[$args_name[$i]]=$par;
	}
}

include("services/".$ws."/ws_include.php");

$WS_RETURN="";

include("services/".$ws."/fn_".$fn.".php");

if($WS_ENDCALL!="") eval($WS_ENDCALL);

if(substr($WS_PARAM["_RT_"],0,1)=="_") $WS_RETURN=WS_CTTOXML($WS_PARAM["_RT_"],$WS_RETURN,0);

header("HTTP/1.1 200 OK");
header("Content-Type: text/xml; charset=utf-8");

$r = dotnettype($WS_PARAM["_RT_"]);
$uri = $WS_PARAM["_NS_"];
$f = $WS_PARAM["_FN_"];

echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>";
?>
<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
  <soap:Body>
<?
if($r=="")
{
?>
    <<? echo $f; ?>Response xmlns="<? echo $uri; ?>" />
<? } else { ?>
    <<? echo $f; ?>Response xmlns="<? echo $uri; ?>">
<? } ?>
      <<? echo $f; ?>Result><? echo $WS_RETURN; ?></<? echo $f; ?>Result>
    </<? echo $f; ?>Response>
  </soap:Body>
</soap:Envelope>