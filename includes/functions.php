<?

$WS_VER="0.3";

if ( !defined('PHP_MY_WEB_SERVICES_FRAMEWORK_RUNTIME') )
{
	header("HTTP/1.1 403 FORBIDDEN");
	die();
}

function xml($file)
{
	global $ref, $wsc, $uri;
	header("Content-Type: text/xml; charset=utf-8");
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>";
//	readfile($file.".xml");
	include("forms/xml/$file.php");
}

function loadws($ws)
{
	global $uri, $wsc;
	if(!is_dir("services/".$ws))
	{
		header("HTTP/1.1 404 Unknow WebService");
		die("404 Unknow WebService");
	}
	if(!file_exists("services/".$ws."/ws_conf.php"))
	{
		header("HTTP/1.1 500 INTERNAL ERROR");
		die("500 Internal Error (ws_conf not found)");
	}
	include("services/".$ws."/ws_conf.php");
	if($wsc!=$ws)
	{
		header("HTTP/1.1 500 INTERNAL ERROR");
		die("500 Internal Error (wsc not match)");
	}
	if($needauth==true) checkauth($ws);
}

function loadfn($fn,$ws)
{
	global $returntype, $args_num, $args_name, $args_type, $usect;
	//echo "services/".$ws."/op_".$fn.".php";
	if(!file_exists("services/".$ws."/op_".$fn.".php"))
	{
		//header("HTTP/1.1 500 INTERNAL ERROR");
		die("500 Internal Error (op_file not found)");
	}
	if(!file_exists("services/".$ws."/fn_".$fn.".php"))
	{
		//header("HTTP/1.1 500 INTERNAL ERROR");
		die("500 Internal Error (fn_file not found)");
	}
	include("services/".$ws."/op_".$fn.".php");
	if($servicename!=$ws)
	{
		//header("HTTP/1.1 500 INTERNAL ERROR");
		die("500 Internal Error (servicename not match)");
	}
	if($functionname!=$fn)
	{
		//header("HTTP/1.1 500 INTERNAL ERROR");
		die("500 Internal Error (functionname not match)");
	}
	
	$usect=false;
	if($args_num>0) {
		for($i=0;$i<$args_num;$i++) {
			if(substr($args_type[$i],0,1)=="_") $usect=true;
		}
	}
}

function loadct($ct,$ws)
{
	global $var_num, $var_name, $var_type;
	
	if(substr($ct,0,1)=="_") $ct=substr($ct,1);

	if(!file_exists("services/".$ws."/ct_".$ct.".php"))
	{
		//header("HTTP/1.1 500 INTERNAL ERROR");
		die("500 Internal Error (ct_file not found for ".$ct.")");
	}
	include("services/".$ws."/ct_".$ct.".php");
	if($servicename!=$ws)
	{
		//header("HTTP/1.1 500 INTERNAL ERROR");
		die("500 Internal Error (servicename not match)");
	}
	if($typename!=$ct)
	{
		//header("HTTP/1.1 500 INTERNAL ERROR");
		die("500 Internal Error (typename not match)");
	}
}

function dotnettype($type)
{
	if(substr($type,0,1)=="_") return substr($type,1);

	switch($type)
	{
		case "string":
		case "int":
			return $type;
			
		case "bool":
			return "boolean";
			
		case "":
		case "void":
		case "null":
			return "";
			
		default: //UNKNOW
			return "string";
	}
}

function checkauth($ws)
{
	if(isset($_SERVER["PHP_AUTH_USER"])) $WS_LOGIN=$_SERVER["PHP_AUTH_USER"];
	if(isset($_SERVER["PHP_AUTH_PW"])) $WS_PASSWORD=$_SERVER["PHP_AUTH_PW"];

	if(!isset($WS_LOGIN)) $WS_LOGIN="";
	if(!isset($WS_PASSWORD)) $WS_PASSWORD="";
	$WS_AUTHOK = false;	
	
	include("services/".$ws."/ws_auth.php");
	
	if($WS_AUTHOK==false)
	{
		header("HTTP/1.1 401 BAD LOGIN");
		header("WWW-Authenticate: Basic realm=\"".$ws." WebService\""); 
		die("401 BAD LOGIN");
	}
}

function WS_MAKECT($type)
{
	global $WS_PARAM, $var_num, $var_name, $var_type;
	$ws = $WS_PARAM["_WS_"];
	
	if(substr($type,0,1)=="_") $type=substr($type,1);
	
	loadct($type,$ws);
	$vc=$var_num;
	$vn=$var_name;
	$vt=$var_type;
	
	if($vc<1) die("500 Internal Error (argsnum is null)");
	
	for($i=0;$i<$vc;$i++) {
		switch($vt[$i])
		{
			case "int":
				$v=0;
				break;
				
			case "string":
				$v="";
				break;
				
			case "bool":
				$v=false;
				break;
				
			default:
				if(substr($vt[$i],0,1)=="_")	$v=WS_MAKECT(substr($vt[$i],1));
					else $v=0;
		}
		$t[$vn[$i]]=$v;
	}
	
	return $t;
}

function WS_CTTOXML($type,$var,$lv)
{
	global $WS_PARAM, $var_num, $var_name, $var_type;
	$ws = $WS_PARAM["_WS_"];
	
	loadct($type,$ws);
	$vc=$var_num;
	$vn=$var_name;
	$vt=$var_type;

	$e=str_repeat(" ",$lv+2);
	
	if($vc<1) die("500 Internal Error (argsnum is null)");
	
	$r="";
	
	for($i=0;$i<$vc;$i++) {
		if(substr($vt[$i],0,1)=="_")
		{
			$r .= $e."<".$vn[$i].">\n".WS_CTTOXML($vt[$i],$var[$vn[$i]],$lv+2)."\n".$e."</".$vn[$i].">\n";
		} else {
			$r .= $e."<".$vn[$i].">".$var[$vn[$i]]."</".$vn[$i].">\n";
		}
	}
	
	return $r;
}

function WS_CTTOSOAP($type,$lv)
{
	global $wsc, $var_num, $var_name, $var_type;
	
	if(substr($type,0,1)=="_") $type=substr($type,1);
	
	loadct($type,$wsc);
	$vc=$var_num;
	$vn=$var_name;
	$vt=$var_type;

	$e=str_repeat(" ",$lv+2);
	
	if($vc<1) die("500 Internal Error (argsnum is null)");
	
	$r="";
	
	for($i=0;$i<$vc;$i++) {
		if(substr($vt[$i],0,1)=="_")
		{
			$r .= $e."&lt;".$vn[$i]."&gt;\n".WS_CTTOSOAP(substr($vt[$i],1),$lv+2)."\n".$e."&lt;/".$vn[$i]."&gt;\n";
		}
		else
		{
			$r .= $e."&lt;".$vn[$i]."&gt;<font class=value>".$vt[$i]."</font>&lt;/".$vn[$i]."&gt;\n";
		}
	}
	
	return trim($r,"\n");
}

function WS_CTDECODE($ct,$data)
{
	global $ws, $var_num, $var_name, $var_type;
	
	loadct($ct,$ws);
	$vc=$var_num;
	$vn=$var_name;
	$vt=$var_type;
	
	for($i=0;$i<$vc;$i++) {
		if(strpos($data,"<".$vn[$i].">")===false) die($vn.": not found");
		if(strpos($data,"</".$vn[$i].">")===false) die($vn[$i].": /not found");
		$len = strlen($vn[$i]);
		$pos = strpos($data,"<".$vn[$i].">")+$len+2;
		$par = substr($data,$pos,strpos($data,"</".$vn[$i].">")-$pos);
		if(substr($vt[$i],0,1)=="_") $WS_PARAM[$vn[$i]]=WS_CTDECODE(substr($vt[$i],1),$par);
			else $r[$vn[$i]]=$par;
	}
	
	return $r;
}

?>