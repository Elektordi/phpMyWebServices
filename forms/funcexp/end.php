<?
if ( !defined('PHP_MY_WEB_SERVICES_FRAMEWORK_RUNTIME') )
{
	header("HTTP/1.1 403 FORBIDDEN");
	die();
}
?>
                  <span>
              <h3>SOAP</h3>
              <p>Le texte suivant est un exemple de demande et de réponse SOAP. Les <font class=value>espaces réservés</font> affichés doivent être remplacés par des valeurs réelles.</p>

              <pre>POST <? echo $asmxref; ?> HTTP/1.1
Host: <? echo $_SERVER["HTTP_HOST"]."\n"; ?>Content-Type: text/xml; charset=utf-8
Content-Length: <font class=value>length</font>
SOAPAction: "<? echo $uri."/".$op; ?>"

&lt;?xml version="1.0" encoding="utf-8"?&gt;
&lt;soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/"&gt;
  &lt;soap:Body&gt;
<?  if($args_num>0) { ?>
    &lt;<? echo $op; ?> xmlns="<? echo $uri; ?>"&gt;
<? for($i=0;$i<$args_num;$i++) {
		$par = $args_name[$i];
		$type = $args_type[$i];
		if(substr($type,0,1)!="_") echo "      &lt;$par&gt;<font class=value>$type</font>&lt;/$par&gt;\n";
			else echo "      &lt;$par&gt;\n".WS_CTTOSOAP(substr($type,1),6)."\n      &lt;/$par&gt;\n";
	}
?>    &lt;/<? echo $op; ?>&gt;
<? } else { echo "    &lt;$op xmlns=\"$uri\" /&gt;\n"; } ?>
  &lt;/soap:Body&gt;
&lt;/soap:Envelope&gt;</pre>

              <pre>HTTP/1.1 200 OK
Content-Type: text/xml; charset=utf-8
Content-Length: <font class=value>length</font>

&lt;?xml version="1.0" encoding="utf-8"?&gt;
&lt;soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/"&gt;
  &lt;soap:Body&gt;
<? if($ret!="") { ?>
    &lt;<? echo $op; ?>Response xmlns="<? echo $uri; ?>"&gt;
<? 		if(substr($returntype,0,1)=="_") echo "      &lt;".$op."Result&gt;\n".WS_CTTOSOAP(substr($returntype,1),6)."\n      &lt;/".$op."Result&gt;\n";
			else { ?>
      &lt;<? echo $op ?>Result&gt;<font class=value><? echo $returntype; ?></font>&lt;/<? echo $op; ?>Result&gt;
<? } ?>
    &lt;/<? echo $op; ?>Response&gt;
<? } else { ?>    &lt;<? echo $op; ?>Response xmlns="<? echo $uri; ?>" /&gt;
<? } ?>
  &lt;/soap:Body&gt;
&lt;/soap:Envelope&gt;</pre>
          </span>

<? if($usect==false) { ?>          

          <span>
              <h3>HTTP POST</h3>
              <p>Le texte suivant est un exemple de demande et de réponse HTTP POST. Les <font class=value>espaces réservés</font> affichés doivent être remplacés par des valeurs réelles.</p>

              <pre>POST <? echo $asmxref."/".$op; ?> HTTP/1.1
Host: <? echo $_SERVER["HTTP_HOST"]."\n"; ?>Content-Type: application/x-www-form-urlencoded
Content-Length: <font class=value>length</font>

<? if($args_num>0) {
$pars = "";
  for($i=0;$i<$args_num;$i++) {
		$par = $args_name[$i];
		$type = $args_type[$i];
        $pars.= "&amp;<font class=key>$par</font>=<font class=value>$type</font>";
	}
	//<font class=key>quote</font>=<font class=value>string</font>&amp;<font class=key>year</font>=<font class=value>string</font>
echo substr($pars,5); }?></pre>
              <pre>HTTP/1.1 200 OK
<? if($ret!="") { ?>
Content-Type: text/xml; charset=utf-8
Content-Length: <font class=value>length</font>

&lt;?xml version="1.0" encoding="utf-8"?&gt;
<? 		if(substr($returntype,0,1)=="_") echo "&lt;$ret xmlns=\"$uri\"&gt;\n".WS_CTTOSOAP(substr($returntype,1),0)."\n&lt;/$ret&gt;\n";
			else { ?>
&lt;<? echo $ret; ?> xmlns="<? echo $uri; ?>"&gt;<font class=value><? echo $returntype; ?></font>&lt;/<? echo $ret; ?>&gt;<? } } ?></pre>
          </span>
<? } ?>
      </span>
<hr>
<p><i>Cette page a &eacute;t&eacute; automatiquement g&eacute;n&eacute;r&eacute;e par phpMyWebServices, syst&egrave;me de programmation en PHP de WebServices compatibles .NET. <a href="http://phpmywebservice.sourceforge.net/">http://phpmywebservice.sf.net/
</a></i></p>
<!-- phpMyWebServices est sous licence OpenSource et réalisé par Elektordi - elektordi[@]yahoo.fr -->
  </body>
</html>