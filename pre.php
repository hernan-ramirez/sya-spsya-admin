<?
$path_de_relacion = "";
include "common/conexion.php";
include "includes/funciones.php";
####### !!!!!!!!! 
if(isset($id)){
?>
<HTML>
<HEAD>
<TITLE>PREVIEW</TITLE>
<META http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK href="<? echo $path_de_relacion ?>includes/estilos_admin.css" rel="stylesheet" type="text/css">
<SCRIPT>
function enviar(texto){
	/*
	for(i=0; i<parent.opener.document.forms[0].length; i++){
		if(parent.opener.document.forms[0].elements[i].name == "<? echo $back_campo ?>"){ //Pongo variable del SELECT en PHP
			campo = parent.opener.document.forms[0].elements[i];
			break;
		}
	}
	if(campo!=null && campo.type.indexOf("select")!=-1){
		campo.name = "s_<? echo $back_campo ?>"; //Renombro SELECT, variable en PHP
		campo.style.display = "none";
		campo = parent.opener.document.forms[0].elements[i+1];
		campo.style.display = "inline";
		campo.name = "<? echo $back_campo ?>"; //Pongo variable del campo OCULTO en PHP
	}
	campo.value = "<? echo $id ?>";
	
	if(campo.name.indexOf("[")==-1){
		parent.opener.document.forms[0].submit();
	}
	
	parent.close();
	*/
	campo_base = "<? echo $back_campo ?>";
	for(i=0; i<parent.opener.document.forms[0].length; i++){
		if(parent.opener.document.forms[0].elements[i].name == "<? echo $back_campo ?>"){ //Pongo variable del SELECT en PHP
			campo = parent.opener.document.forms[0].elements[i];
			break;
		}
	}
	
	var newElem = parent.opener.document.createElement("OPTION");
	newElem.text = texto;
	newElem.value = "<? echo $id ?>";
	campo.options.add(newElem);
	campo.options[campo.length-1].selected = true;
	campo.focus();
	window.close();
}
</SCRIPT>
</HEAD>
<BODY leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<TABLE width="100%" border="0" cellspacing="0" cellpadding="0">
  <?
$strQuery = "SELECT * FROM " . $tabla . " WHERE id=" . $id;
$query = mysql_query($strQuery);
$cantidad_campos = mysql_num_fields($query);
$row = mysql_fetch_array($query);
for($Campo = 0; $Campo < $cantidad_campos; $Campo++){
	$nom = mysql_field_name($query,$Campo);
	$tip = mysql_field_type($query,$Campo);
	$leyenda_extendida = true;
	
	$mostrar_imagen = true;
?>
  <TR>
	<TD class="Celeste"><B><? leyenda_campo($query,$Campo) ?></B></TD>
  </TR>
  <TR>
	<TD class="Blanco"><? leyenda_contenidos($row,$query,$Campo, $base) ?></TD>
  </TR>
<?
} ## FIN DEL FOR
?>
  <TR>
	<TD align="center">
<INPUT name="seleccionar" type="button" value="SELECCIONAR" onClick="javascript:enviar('<? echo str_replace('"','',$row[1]); ?>');" class="bot"></TD>
  </TR>
</TABLE>
</BODY>
</HTML>
<? } ## del if  ?>

