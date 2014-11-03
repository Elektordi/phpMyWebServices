<?
if ( !defined('PHP_MY_WEB_SERVICES_FRAMEWORK_RUNTIME') )
{
	header("HTTP/1.1 403 FORBIDDEN");
	die();
}

$query = trim($_SERVER["QUERY_STRING"]);

if(isset($_SERVER["PATH_INFO"])) if($_SERVER["PATH_INFO"]=="/")
{
	header("Location: ../mws.php");
	die("Redirection: <a href=\"../mws.php\">index</a>");
}

if(!isset($_SERVER["PATH_INFO"]))
{
  if(strtolower($query)=="disco")
  {
  	xml("global_disco");
	die();
  }
  include("forms/index/head.php");
  function MakePub($ws) { if(is_dir("services/".$ws)) {include("forms/index/svc.php");} else {include("forms/index/svc_err.php");} }
  include("services/list.php");
  include("forms/index/end.php");
}

if($query != "" && isset($_SERVER["PATH_INFO"]))
{
  $wsrv = rtrim(ltrim($_SERVER["PATH_INFO"],"/"),".asmx");
  loadws($wsrv);
  $ref = "http://".$_SERVER["HTTP_HOST"].":".$_SERVER["SERVER_PORT"].substr($_SERVER["REQUEST_URI"],0,strpos($_SERVER["REQUEST_URI"],"?"));
  switch(strtolower($query))
  {
  	case "wsdl":
		//echo "Demande du descripteur de service du webservice \"$wsrv\"";
		xml("wsdl");
		die();
	case "disco":
		//echo "Demande de découverte du webservice \"$wsrv\"";
		xml("disco");
		die();
  }
  if(isset($HTTP_GET_VARS["op"]))
  {
  	$op = $HTTP_GET_VARS["op"];
  	//echo "Demande de la page \"$op\" du webservice \"$wsrv\"";
	loadfn($op,$wsc);
	include("forms/funcexp/head.php");
	$postref=$ref."/".$op;
    if($usect==false) include("forms/funcexp/test.php");
		else echo "La requête POST n'est disponible que pour les méthodes dont les paramètres sont des types primitifs.";// ou des tableaux de types primitifs.";
	$asmxref=substr($_SERVER["REQUEST_URI"],0,strpos($_SERVER["REQUEST_URI"],"?"));
	$ret = dotnettype($returntype);
    include("forms/funcexp/end.php");
	die();
  }
  //echo "Demande inconnue \"$query\" au webservice \"$wsrv\"";
  $query="";
}

if($query == "" && isset($_SERVER["PATH_INFO"]))
{
  $wsrv = rtrim(ltrim($_SERVER["PATH_INFO"],"/"),".asmx");
  loadws($wsrv);
  include("forms/wsmain/head.php");
  $d = dir("services/".$wsrv."/");
  while (false !== ($opc = $d->read())) {
    if(substr($opc,0,3)=="op_" && substr($opc,strlen($opc)-4)==".php")
	{
		$opc = substr($opc,3,strlen($opc)-7);
		include("forms/wsmain/op.php");
	}
  }
  $d->close();
  include("forms/wsmain/end.php");
}
?>