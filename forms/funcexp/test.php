<?
if ( !defined('PHP_MY_WEB_SERVICES_FRAMEWORK_RUNTIME') )
{
	header("403 FORBIDDEN");
	die();
}
?>          
          Pour tester l'opération en utilisant le protocole HTTP POST, cliquez sur le bouton 'Appeler'.

                      <form target="_blank" action='<? echo $postref; ?>' method="POST">                      
                        
                          <table cellspacing="0" cellpadding="4" frame="box" bordercolor="#dcdcdc" rules="none" style="border-collapse: collapse;">
<? if($args_num>0) { ?>
                          <tr>
	<td class="frmHeader" background="#dcdcdc" style="border-right: 2px solid white;">Paramètre</td>
	<td class="frmHeader" background="#dcdcdc">Valeur</td>
</tr>

<? for($i=0;$i<$args_num;$i++) {
	$par = $args_name[$i];?>
                          <tr>
                            <td class="frmText" style="color: #000000; font-weight: normal;"><? echo $par; ?>:</td>
                            <td><input class="frmInput" type="text" size="50" name="<? echo $par; ?>"></td>
                          </tr>
<? }
} ?>
                        <tr>
                          <td></td>
                          <td align="right"> <input type="submit" value="Appeler" class="button"></td>
                        </tr>
                        </table>
                      

                    </form>