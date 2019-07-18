<?
$path = "../";
include $path."common/conexion.php";
?>
<HTML>
<HEAD>
<TITLE>Administrador de Newsletter<? echo str_repeat("&nbsp;",50) ?></TITLE>
<META http-equiv="" content="text/html; charset=iso-8859-1">
<STYLE>
body, td, select, input, textarea{
	font-family:arial;
	font-size:11px;
}
select,input,textarea{
	width:100%;
}
.botones {
	font-family: Webdings;
	font-size: 13px;
	cursor: hand;
}
FIELDSET{
	width:100%;
	height:100%;
}
</STYLE>
<SCRIPT language="JavaScript" src="../includes/javas.js"></SCRIPT>
<SCRIPT>
function lanzar(){
	if(confirm("ESTA SEGURO DE LANZAR EL NEWSLETTER '" + document.all.txtUbicacion.value + "' A\nLA LISTA O MAILS '" + document.all.lista.value + " " + document.all.casilla.value + "' ????")){
		document.forms[0].action = "?submit=si";
		document.forms[0].submit();
	}else{
		document.forms[0].action = "";
	}
}
</SCRIPT>
</HEAD>

<BODY bgcolor="#D4D0c8" style="border:0;margin:0;" scroll="no">
<?
########### Acciones ############
if($submit == "si"){
	$headers  = "MIME-Version: 1.0\r\n"; 
	$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
	$headers .= "From: SportsYA! <info@sportsya.com>\r\n";
	if( $lista != "" ){ $to = $lista; }
	if( $casilla != "" ){ 
		if( strlen($to) >>  1 ){ 
			$to .= ", " . $casilla; 
		}else{ 
			$to = $casilla; 
		}
	} 
	if( mail($to , $asunto, $cuerpo, $headers) ){
		$enviados = '
		<FIELDSET>
		<LEGEND>News Enviados</LEGEND>
		' . $to . '
		</FIELDSET>';
	}
}
###############################
?>
<TABLE width="100%" height="100%" border="0" cellpadding="8" cellspacing="8">
<FORM name="newsform" action="" method="post">
  <TR align="center" valign="top"> 
    <TD width="50%" height="30"> <FIELDSET>
      <LEGEND>Seleccione un Newsletter</LEGEND>
      <TABLE width="100%" border="0" cellspacing="0" cellpadding="0">
        <TR> 
          <TD width="100%"> <INPUT name="txtUbicacion" type="text" id="txtUbicacion" value="<? echo $txtUbicacion ?>"> 
            <INPUT type="hidden" name="id_estructura" value="<? echo $id_estructura ?>"> </TD>
          <TD> <INPUT name="sel_ubi" type="button"  class="bot" onClick="abrirVentana('ow.php?tabla=estructura&include=estructura&usuario_admin=<? echo $usuario_admin ?>&seleccionar=si&path=../','ubi','450','350')" value="Seleccionar" > 
          </TD>
          <TD><INPUT type="submit" value="Refrescar"></TD>
        </TR>
      </TABLE>
      </FIELDSET></TD>
    <TD width="50%" height="30"><? if(isset($enviados)){ echo $enviados; } ?></TD>
  </TR>
  <TR align="center" valign="top"> 
    <TD colspan="2"><IFRAME name="notis" src="news.php?id_estructura=<? echo $id_estructura ?>" scrolling="auto" style="width:100%;height:100%"></IFRAME></TD>
  </TR>
  <TR align="center" valign="top"> 
    <TD height="30">&nbsp;</TD>
    <TD width="50%" height="30"><FIELDSET>
      <LEGEND> Datos del mail </LEGEND>
	  Asunto del mail 
      <INPUT name="asunto" type="text" id="asunto">
      Seleccione una Lista
      <SELECT name="lista" id="lista">
        <OPTION value="">-- Cada lista contiene mails de miles de usuarios --</OPTION>
        <OPTION value="concurso@sportsya.com">Concurso</OPTION>
        <OPTION value="deporte@sportsya.com">Deporte</OPTION>
        <OPTION value="deportear@sportsya.com">Deportes de Argentina</OPTION>
        <OPTION value="deportemx@sportsya.com">Deportes de Mexico</OPTION>
        <OPTION value="deporteus@sportsya.com">Deportes de USA </OPTION>
        <OPTION value="futbol@sportsya.com">Lista de F&uacute;tbol</OPTION>
        <OPTION value="futbolar@sportsya.com">F&uacute;tbol de Argentina</OPTION>
        <OPTION value="futbolmx@sportsya.com">F&uacute;tbol de M&eacute;xico</OPTION>
        <OPTION value="tenis@sportsya.com">Lista de Tenis </OPTION>
        <OPTION value="tenisar@sportsya.com">Tenis de Argentina </OPTION>
        <OPTION value="usuarios@sportsya.com">Usuarios Anteriores </OPTION>
      </SELECT>
      O una casilla en particular (ej: estacuenta@hotmail.com) 
      <TABLE width="100%" border="0" cellspacing="0" cellpadding="0">
  <TR>
    <TD width="50%"><INPUT name="casilla" type="text" id="casilla"></TD>
    <TD width="50%"><INPUT type="button" value="Lanzar Newsletter" onClick="lanzar();"></TD>
  </TR>
</TABLE>        
      <TEXTAREA name="cuerpo" style="display:none"><? include "news.php"; ?></TEXTAREA>
      </FIELDSET></TD>
  </TR>
</FORM>
</TABLE>
</BODY>
</HTML>
