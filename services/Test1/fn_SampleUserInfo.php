<?
// Security block, do not edit...
if ( !defined('PHP_MY_WEB_SERVICES_FRAMEWORK_RUNTIME') )
{
	header("HTTP/1.1 403 FORBIDDEN");
	die();
}
// End of security block...

$name = $WS_PARAM["name"];
$objd = $WS_PARAM["birth"];

$birth = mktime(0,0,0,$objd["mounth"],$objd["day"],$objd["year"]); // ERR ?

$r=WS_MAKECT("user");
$next=WS_MAKECT("date");

$thisyear = date("Y");

$age = $thisyear - date("Y",$birth);
$ip = $_SERVER["REMOTE_ADDR"];

// test:
$WS_LANG="fr";

if($WS_LANG=="fr")
{
	$infos="Votre ip est $ip, votre nom est $name, vous avez $age ans !";
}
else
{
	$infos="Your ip is $ip, your name is $name and you are $age years old !";
}

$next["day"]=$objd["day"];
$next["mounth"]=$objd["mounth"];
$next["year"]=$thisyear;

if(mktime(0,0,0,$next["mounth"],$next["day"],$next["year"])<time()) $next["year"]++;

$r["id"]=$birth;
$r["name"]=$name;
$r["infos"]=$infos;
$r["next_birthday"]=$next;

$WS_RETURN = $r;

?>