<?
include "common/conexion.php";
include "includes/funciones.php";
/*
if(isset($usuario) && $clave != ""){
	$sql = "SELECT * FROM usuarios WHERE usuario = '" . $usuario . "' AND clave = PASSWORD('" . $clave . "');";
	$result = mysql_query($sql);
	if (mysql_num_rows($result)!=0){ 	
		$row_usuario = mysql_fetch_array($result);
		setcookie("id_usuario", $row_usuario['id'],time()+12*3600);
		$id_usuario = $row_usuario['id'];
	} else {
		echo "Ingreso mal alguno de los datos, intente nuevamente<BR>";
	}
}
*/
?>
<HTML>
<HEAD>
<TITLE>:: Mediadev V 0.11 ::</TITLE>
<META http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK href="includes/estilos_admin.css" rel="stylesheet" type="text/css">
<SCRIPT language="JavaScript" src="includes/javas.js" type="text/javascript"></SCRIPT>
<SCRIPT>
window.name = "principal";
</SCRIPT>
</HEAD>
<BODY leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?
//######################FORMULARIO DE INGRESO#########################
if (!isset($id_usuario)){
?>
<table width="442" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p></td>
  </tr>
</table>
<table width="442" border="0" align="center" cellpadding="0" cellspacing="0"> 
<FORM name="menu" method="post" action="<? echo $PHP_SELF ?>">  <tr> 
    <td width="1" bgcolor="D6E7F7"><img src="../image/spacer.gif" width="1" height="1"></td>
    <td bgcolor="D6E7F7"><img src="../image/spacer.gif" width="1" height="1"></td>
    <td bgcolor="59718E"><img src="../image/spacer.gif" width="1" height="1"></td>
    <td width="1"><img src="../image/spacer.gif" width="1" height="1"></td>
  </tr>
  <tr> 
    <td bgcolor="D6E7F7"><img src="../image/spacer.gif" width="1" height="1"></td>
    <td width="438"><table width="438" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td class="HeaderBack"><table border="0" cellpadding="0" cellspacing="0">
              <tr> 
                <td><img src="../image/spacer.gif" width="3" height="1"></td>
                <td nowrap class="HeaderDate">Ingrese su nombre de operador y 
                  password</td>
              </tr>
            </table></td>
        </tr>
        <tr> 
          <td width="1" bgcolor="59718E"><img src="../image/spacer.gif" width="1" height="1"></td>
        </tr>
        <tr> 
          <td width="1" bgcolor="B1D6FD"><img src="../image/spacer.gif" width="1" height="1"></td>
        </tr>
        <tr> 
          <td align="center"><table width="333" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td width="50"><img src="../image/spacer.gif" width="1" height="15"></td>
                <td width="100%"><img src="../image/spacer.gif" width="1" height="15"></td>
              </tr>
              <tr> 
                <td class="TxtLogin">Usuario</td>
                <td><INPUT name="usuario" type="text" class="selectINT" id="usuario">
                  </td>
              </tr>
              <tr> 
                <td><img src="../image/spacer.gif" width="1" height="8"></td>
                <td><img src="../image/spacer.gif" width="1" height="8"></td>
              </tr>
              <tr> 
                <td width="1" bgcolor="#FFFFFF"><img src="../image/spacer.gif" width="1" height="1"></td>
                <td bgcolor="#FFFFFF"><img src="../image/spacer.gif" width="1" height="1"></td>
              </tr>
              <tr> 
                <td><img src="../image/spacer.gif" width="1" height="8"></td>
                <td><img src="../image/spacer.gif" width="1" height="8"></td>
              </tr>
              <tr> 
                <td class="TxtLogin">Password</td>
                <td><INPUT name="clave" type="password" class="selectINT" id="clave"></td>
              </tr>
              <tr> 
                <td><img src="../image/spacer.gif" width="1" height="8"></td>
                <td><img src="../image/spacer.gif" width="1" height="8"></td>
              </tr>
              <tr> 
                <td bgcolor="#FFFFFF"><img src="../image/spacer.gif" width="1" height="1"></td>
                <td bgcolor="#FFFFFF"><img src="../image/spacer.gif" width="1" height="1"></td>
              </tr>
              <tr> 
                <td><img src="../image/spacer.gif" width="1" height="8"></td>
                <td><img src="../image/spacer.gif" width="1" height="8"></td>
              </tr>
              <tr> 
                <td><img src="../image/spacer.gif" width="1" height="8"></td>
                <td><img src="../image/spacer.gif" width="1" height="8"></td>
              </tr>
              <tr> 
                <td>&nbsp;</td>
                <td align="right"><table border="0" cellspacing="0" cellpadding="0">
                    <tr> 
                      <td>
                          <INPUT name="Submit" type="submit" class="bot" value="Log In"></td>
                                         </tr>
                  </table></td>
              </tr>
              <tr> 
                <td><img src="../image/spacer.gif" width="1" height="15"></td>
                <td><img src="../image/spacer.gif" width="1" height="15"></td>
              </tr>
            </table></td>
        </tr>
      </table></td>
    <td width="1" bgcolor="59718E"><img src="../image/spacer.gif" width="1" height="1"></td>
    <td bgcolor="6B85A3"><img src="../image/spacer.gif" width="2" height="1"></td>
  </tr>
  <tr> 
    <td bgcolor="59718E"><img src="../image/spacer.gif" width="1" height="1"></td>
    <td bgcolor="59718E"><img src="../image/spacer.gif" width="1" height="1"></td>
    <td bgcolor="59718E"><img src="../image/spacer.gif" width="1" height="1"></td>
    <td bgcolor="6B85A3"><img src="../image/spacer.gif" width="2" height="1"></td>
  </tr>
  <tr> 
    <td><img src="../image/spacer.gif" width="1" height="2"></td>
    <td bgcolor="6B85A3"><img src="../image/spacer.gif" width="2" height="2"></td>
    <td bgcolor="6B85A3"><img src="../image/spacer.gif" width="2" height="2"></td>
    <td bgcolor="6B85A3"><img src="../image/spacer.gif" width="2" height="2"></td>
  </tr>
  </FORM>
</table>
<?	 
//######################DESPLIEGUE DE ACCESO#########################
} else{
 
 	$result = mysql_query("SELECT * FROM usuarios WHERE id=" . $id_usuario);
	$row_usuario = mysql_fetch_array($result);
?>	
<table border="0" cellspacing="0" cellpadding="0">
	    
  <tr>
		  
    <td height="22"><font color="#FFFFFF">&nbsp;Usuario: <b><? echo $row_usuario['nombre'] . " " . $row_usuario['apellido'] ?></b></font>
		</td>
  </tr>
      
</table>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="2" height="1"><img src="../../image/spacer.gif" width="2" height="1"></td>
    <td width="1" height="1" class="Black"><img src="../../image/spacer.gif" width="1" height="1"></td>
    <td width="165" height="1" class="Black"><img src="../../image/spacer.gif" width="165" height="1"></td>
    <td width="1" height="1" class="Black"><img src="../../image/spacer.gif" width="1" height="1"></td>
    <td width="2" height="1"><img src="../../image/spacer.gif" width="2" height="1"></td>
    <td width="1" height="1" class="Black"><img src="../../image/spacer.gif" width="1" height="1"></td>
    <td width="100%" height="1" class="Black"><img src="../../image/spacer.gif" width="1" height="1"></td>
    <td width="1" height="1"class="Black"><img src="../../image/spacer.gif" width="1" height="1"></td>
    <td width="2" height="1"><img src="../../image/spacer.gif" width="2" height="1"></td>
  </tr>
  <tr> 
    <td><img src="../../image/spacer.gif" width="2" height="1"></td>
    <td class="Black"><img src="../../image/spacer.gif" width="1" height="1"></td>
    <td valign="top"><? include "backend_menu.inc.php" ?></td>
    <td class="white"><img src="../../image/spacer.gif" width="1" height="1"></td>
    <td><img src="../../image/spacer.gif" width="2" height="1"></td>
    <td class="Black"><img src="../../image/spacer.gif" width="1" height="1"></td>
    <td valign="top">
	<?
		//--------------------------LISTADO DE TABLAS-----------------------------
		require_once "abm_query.inc.php";
		if (isset($tabla) && $tabla!="" && $include !=""){ 
			require_once $include . ".php";
		} 
	?>
      </td>
    <td class="white"><img src="../../image/spacer.gif" width="1" height="1"></td>
    <td><img src="../../image/spacer.gif" width="1" height="1"></td>
  </tr>
  <tr> 
    <td width="2" height="1"><img src="../../image/spacer.gif" width="2" height="1"></td>
    <td width="1" height="1" class="Black"><img src="../../image/spacer.gif" width="1" height="1"></td>
    <td width="1" height="1" class="white"><img src="../../image/spacer.gif" width="1" height="1"></td>
    <td width="1" height="1" class="white"><img src="../../image/spacer.gif" width="1" height="1"></td>
    <td width="2" height="1"><img src="../../image/spacer.gif" width="2" height="1"></td>
    <td width="1" height="1" class="Black"><img src="../../image/spacer.gif" width="1" height="1"></td>
    <td height="1" class="white"><img src="../../image/spacer.gif" width="1" height="1"></td>
    <td width="1" height="1" class="white"><img src="../../image/spacer.gif" width="1" height="1"></td>
    <td width="2" height="1"><img src="../../image/spacer.gif" width="2" height="1"></td>
  </tr>
  <tr>
    <td><img src="../../image/spacer.gif" width="2" height="1"></td>
    <td><img src="../../image/spacer.gif" width="1" height="1"></td>
    <td>&nbsp;</td>
    <td><img src="../../image/spacer.gif" width="1" height="1"></td>
    <td><img src="../../image/spacer.gif" width="2" height="1"></td>
    <td><img src="../../image/spacer.gif" width="1" height="1"></td>
    <td>&nbsp;</td>
    <td><img src="../../image/spacer.gif" width="1" height="1"></td>
    <td>&nbsp;</td>
  </tr>
</table>
<? } ?>
</BODY>
</HTML>

