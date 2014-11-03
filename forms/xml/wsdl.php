<? if ( !defined('PHP_MY_WEB_SERVICES_FRAMEWORK_RUNTIME') )
{
	header("HTTP/1.1 403 FORBIDDEN");
	die();
}
?>
<definitions xmlns:http="http://schemas.xmlsoap.org/wsdl/http/" xmlns:soap="http://schemas.xmlsoap.org/wsdl/soap/" xmlns:s="http://www.w3.org/2001/XMLSchema" xmlns:s0="<? echo $uri; ?>" xmlns:soapenc="http://schemas.xmlsoap.org/soap/encoding/" xmlns:tm="http://microsoft.com/wsdl/mime/textMatching/" xmlns:mime="http://schemas.xmlsoap.org/wsdl/mime/" targetNamespace="<? echo $uri; ?>" xmlns="http://schemas.xmlsoap.org/wsdl/">
  <types>
    <s:schema elementFormDefault="qualified" targetNamespace="<? echo $uri; ?>">
<?
  $d = dir("services/".$wsc."/");
  while (false !== ($ctc = $d->read())) {
    if(substr($ctc,0,3)=="ct_" && substr($ctc,strlen($ctc)-4)==".php")
	{
		$ct = substr($ctc,3,strlen($ctc)-7);
		include("services/".$wsc."/ct_".$ct.".php");
?>
      <s:complexType name="<? echo $ct; ?>">
        <s:sequence>
<? for($i=0;$i<$var_num;$i++) {
				$par = $var_name[$i]; $dnt = dotnettype($var_type[$i]);
				$s="s"; if(substr($var_type[$i],0,1)=="_") $s="s0";?>
          <s:element minOccurs="1" maxOccurs="1" name="<? echo $par; ?>" type="<? echo $s; ?>:<? echo $dnt; ?>" />
<? } ?>
        </s:sequence>
      </s:complexType>
<? } } 

  $d = dir("services/".$wsc."/");
  while (false !== ($opc = $d->read())) {
    if(substr($opc,0,3)=="op_" && substr($opc,strlen($opc)-4)==".php")
	{
		$op = substr($opc,3,strlen($opc)-7);
		include("services/".$wsc."/op_".$op.".php");
//		loadfn($op,$wsc);
		$rtype=dotnettype($returntype);
?>
      <s:element name="<? echo $op; ?>">
<? if($args_num>0) { ?>
        <s:complexType>
          <s:sequence>
<? for($i=0;$i<$args_num;$i++) {
				$par = $args_name[$i]; $dnt = dotnettype($args_type[$i]);
				$s="s"; if(substr($args_type[$i],0,1)=="_") $s="s0"; ?>
            <s:element minOccurs="1" maxOccurs="1" name="<? echo $par; ?>" type="<? echo $s; ?>:<? echo $dnt; ?>" />
<? } ?>
          </s:sequence>
        </s:complexType>
<? } else { echo "        <s:complexType />\n"; } ?>
      </s:element>
      <s:element name="<? echo $op; ?>Response">
<? if($rtype!="") { 
$s="s"; if(substr($returntype,0,1)=="_") $s="s0";?>
        <s:complexType>
          <s:sequence>
            <s:element minOccurs="1" maxOccurs="1" name="<? echo $op; ?>Result" type="<? echo $s; ?>:<? echo $rtype; ?>" />
          </s:sequence>
        </s:complexType>
<? } else { echo "        <s:complexType />\n"; } ?>
      </s:element>
<?
	}
  }
  $d->close();
?>
    </s:schema>
  </types>
<?   $d = dir("services/".$wsc."/");
  while (false !== ($opc = $d->read())) {
    if(substr($opc,0,3)=="op_" && substr($opc,strlen($opc)-4)==".php")
	{
		$op = substr($opc,3,strlen($opc)-7);
?>
  <message name="<? echo $op; ?>SoapIn">
    <part name="parameters" element="s0:<? echo $op; ?>" />
  </message>
  <message name="<? echo $op; ?>SoapOut">
    <part name="parameters" element="s0:<? echo $op; ?>Response" />
  </message>
<?
	}
  }
  $d->close();
?>
  <portType name="<? echo $wsc; ?>Soap">
<?   $d = dir("services/".$wsc."/");
  while (false !== ($opc = $d->read())) {
    if(substr($opc,0,3)=="op_" && substr($opc,strlen($opc)-4)==".php")
	{
		$op = substr($opc,3,strlen($opc)-7);
?>
    <operation name="<? echo $op; ?>">
      <input message="s0:<? echo $op; ?>SoapIn" />
      <output message="s0:<? echo $op; ?>SoapOut" />
    </operation>
<?
	}
  }
  $d->close();
?>
  </portType>
  <binding name="<? echo $wsc; ?>Soap" type="s0:<? echo $wsc; ?>Soap">
    <soap:binding transport="http://schemas.xmlsoap.org/soap/http" style="document" />
<?   $d = dir("services/".$wsc."/");
  while (false !== ($opc = $d->read())) {
    if(substr($opc,0,3)=="op_" && substr($opc,strlen($opc)-4)==".php")
	{
		$op = substr($opc,3,strlen($opc)-7);
?>
    <operation name="<? echo $op; ?>">
      <soap:operation soapAction="<? echo $uri; ?>/<? echo $op; ?>" style="document" />
      <input>
        <soap:body use="literal" />
      </input>
      <output>
        <soap:body use="literal" />
      </output>
    </operation>
<?
	}
  }
  $d->close();
?>
  </binding>
  <service name="<? echo $wsc; ?>">
    <port name="<? echo $wsc; ?>Soap" binding="s0:<? echo $wsc; ?>Soap">
      <soap:address location="<? echo $ref; ?>" />
    </port>
  </service>
</definitions>