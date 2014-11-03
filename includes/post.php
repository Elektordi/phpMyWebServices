<?
if ( !defined('PHP_MY_WEB_SERVICES_FRAMEWORK_RUNTIME') )
{
	header("HTTP/1.1 403 FORBIDDEN");
	die();
}

if(!isset($_SERVER["PATH_INFO"])) die("NO TARGET FOR POST");
$ws = ltrim($_SERVER["PATH_INFO"],"/");
$fn = substr($ws,strpos($ws,"/")+1);
$ws = substr($ws,0,strpos($ws,"/"));
$ws = rtrim($ws,".asmx");

loadws($ws);
loadfn($fn,$ws);

if($usect==true) die("500 Bad request (Complex types only in SOAP mode !)");

$WS_PARAM["_PHP_MWS_"]="phpMyWebServices v".$WS_VER;
$WS_PARAM["_WS_"]=$ws;
$WS_PARAM["_FN_"]=$fn;
$WS_PARAM["_RT_"]=$returntype;
$WS_PARAM["_NS_"]=$uri;

if($args_num>0) {
	for($i=0;$i<$args_num;$i++) {
		if(!isset($_POST[$args_name[$i]])) die($args_name[$i].": not found");
		$WS_PARAM[$args_name[$i]]=$_POST[$args_name[$i]];
	}
}

include("services/".$ws."/ws_include.php");

$WS_RETURN="";

include("services/".$ws."/fn_".$fn.".php");

if($WS_ENDCALL!="") eval($WS_ENDCALL);

if(substr($WS_PARAM["_RT_"],0,1)=="_") $WS_RETURN=WS_CTTOXML($WS_PARAM["_RT_"],$WS_RETURN,0);

$r = dotnettype($WS_PARAM["_RT_"]);

header("HTTP/1.1 200 OK");

if($r=="") die();

header("Content-Type: text/xml; charset=utf-8");

$uri = $WS_PARAM["_NS_"];

echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
echo "<$r xmlns=\"$uri\">$WS_RETURN</$r>";

?>