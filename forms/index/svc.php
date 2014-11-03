<?
if ( !defined('PHP_MY_WEB_SERVICES_FRAMEWORK_RUNTIME') )
{
	header("403 FORBIDDEN");
	die();
}
?>
              <li>
                <a href="mws.php/<? echo $ws; ?>.asmx"><? echo $ws; ?></a>
                <br><br><pre><? include("services/".$ws."/ws_info.php"); ?></pre>
              </li>