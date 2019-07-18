<? 
require_once "abm_query.inc.php";
//######################## JS #####################################
?>
<SCRIPT language="JavaScript">
<!-- comprovacion de modificacion del campo por HJR
function envio(){
	pass = 1;
	var nombre_campo = new Array();
<? $cont = 0; 
	FOR($Campo = 0; $Campo < $cantidad_campos; $Campo++){ 
			if(mysql_field_name($query,$Campo) != "id" && strstr(mysql_field_flags ($query, $Campo), "not_null") != false){ 
 ?>	nombre_campo[<? echo $cont ?>] = "<? echo mysql_field_name($query,$Campo) ?>"; 
 <? $cont++;
			 }
		}?>
	for (var i=0; i<nombre_campo.length; i++){
		campo_base = nombre_campo[i];
		
		for (var u=0; u<document.formulario_abm.length; u++){
			campo_form = document.formulario_abm.elements[u].name;
			if(campo_form == campo_base){
				campo_extra = document.formulario_abm.elements[u];
			}else	if(campo_form.indexOf(campo_base)!=-1){
				campo = document.formulario_abm.elements[u];
			}
		}
		if( campo.type == "select-one" ){
			if(campo.selectedIndex==-1){
				alert("Olvidó seleccionar una opción en el campo " + campo_base.toUpperCase());
				pass = 0;
			}
			
		}else if( campo.value == "" ){
			alert("Olvidó llenar el campo " + campo_base.toUpperCase());
			pass = 0;
		}
		
	}
	
	if (pass == 1){
		document.formulario_abm.submit();
	}
}
function agregarVinculado(tabla){
	archivo = "<? if(isset($path_de_relacion)){ echo $path_de_relacion;} ?>ow.php?accion=agregar&tabla="+ tabla + "&base=<? echo $base ?>";
	nombre_ventana = "agregar_" + tabla[1];
	window.open(archivo, nombre_ventana, "WIDTH=300, HEIGHT=250, scrollbars, resizable, top=150, left=150");
}
//-->
</SCRIPT>
<? 
//######################## VOLCADO ##################################### 
?>
<LINK href="includes/estilos_admin.css" rel="stylesheet" type="text/css">
<FORM name="formulario_abm" method="post" action="<? echo $PHP_SELF ?>?include=<? if(isset($include)){ echo $include;} ?>&ejecutar=<? echo strtoupper($accion) ?>&accion=<? echo $accion; if(isset($id)){ echo '&id=' . $id;}; if(isset($back_campo)){ echo '&back_campo=' .$back_campo; } ?>" enctype="multipart/form-data">
    <INPUT name="tabla" type="hidden" value="<? echo $tabla ?>">
    <INPUT name="base" type="hidden" value="<? echo $base ?>">
    <? if(isset($num_pagina)){ ?>
    <INPUT name="num_pagina" type="hidden" value="<? echo $num_pagina ?>">
    <? } ?>
    <? if(isset($ordenado)){ ?>
    <INPUT name="ordenado" type="hidden" value="<? echo $ordenado ?>">
    <? } ?>
    <? if(isset($ordenado_forma)){ ?>
    <INPUT name="ordenado_forma" type="hidden" value="<? echo $ordenado_forma ?>">
    <? } ?>
    <?	if (isset($buscar)){
	 while (list($clave, $valor) = each ($var_buscar)) { ?>
    <INPUT name="var_buscar[<? echo $clave ?>]" type="hidden" value="<? echo $valor ?>">
    <? } ?>
    <INPUT name="buscar" type="hidden" value="realizar">
    
  <? } 
  include "abm_header.php";  
  ?>
        
 
  <TABLE width="100%" border="0" cellspacing="0" cellpadding="0">
    <TR> 
		<TD width="15%" class="HeaderContenido">Campo</TD>
		<TD width="1" bgcolor="D6EBFF"><IMG src="../image/spacer.gif" width="1" height="1"></TD>
		<TD width="85%" class="HeaderContenido">Datos</TD>
    </TR>
</TABLE>
  <TABLE width="100%" border="0" cellspacing="0" cellpadding="0">
          
    <? FOR($Campo = 0; $Campo < $cantidad_campos; $Campo++){ 
	 		 if (mysql_field_name($query,$Campo) != "log" 
			 && mysql_field_name($query,$Campo) != "fecha_stmp" 
			 && mysql_field_name($query,$Campo) != "_timestamp" 
			 && mysql_field_name($query,$Campo) != "_id_usuario" 
			 && mysql_field_name($query,$Campo) != "id"
			 ){ ?>
    <TR<? if((isset($oculto_abm) && $oculto_abm!="") && strstr(",".$oculto_abm.",", ",".mysql_field_name($query,$Campo).",")!=false ){ echo " style='display:none'";} ?>> 
            
      <TD align="right" width="15%" valign="top" class="Celeste">
        <TABLE width="100%" border="0" cellspacing="0" cellpadding="0">
          <TR>
            <TD class="Celeste" align="right" height="20">
              <? leyenda_campo($query,$Campo) ?>
            </TD>
          </TR>
        </TABLE>
        </TD>
      <TD bgcolor="#D6EBFF" width="1"><IMG src="image/spacer.gif" width="1" height="1"></TD>
      <TD class="Celeste"> 
              
        <SPAN class="selectINT">
        <? if (isset($buscar) && $accion == "agregar"){
					tipo_campo("agregar_buscada", $query, $Campo, $var_buscar, $base);
			  	}else{
					tipo_campo($accion, $query, $Campo, $row, $base);
				} ?>
        </SPAN>
      </TD>
    </TR>
    <TR<? if((isset($oculto_abm) && $oculto_abm!="") && strstr(",".$oculto_abm.",", ",".mysql_field_name($query,$Campo).",")!=false ){ echo " style='display:none'";} ?> bgcolor="#D6EBFF">
      <TD><IMG src="image/spacer.gif" width="1" height="1"></TD>
      <TD width="1"><IMG src="image/spacer.gif" width="1" height="1"></TD>
      <TD bgcolor="#D6EBFF"><IMG src="image/spacer.gif" width="1" height="1"></TD>
    </TR>
		 
    <? }else{ 
		 		switch(mysql_field_name($query,$Campo)){
				case "log":
		 			$who = strtoupper(substr($row_log['nombre'], 0, 1)) . strtoupper(substr($row_log['apellido'], 0, 1));  ?>
  					
    <INPUT name="<? echo "var_" . $accion . "[log]" ?>" type="hidden" value="<? echo $who ?>">
		 
    <? 	break;	
		 		case "fecha_stmp":
					$fecha_stmp = date("Y-m-d"); ?>  					
    <INPUT name="<? echo "var_" . $accion . "[fecha_stmp]" ?>" type="hidden" value="<? echo $fecha_stmp ?>">		 
<?	 break;
		 		case "_timestamp":
					?><INPUT name="<? echo "var_" . $accion . "[_timestamp]" ?>" type="hidden" value="NOW()+0"><?	 
				break;
		 		case "_id_usuario":
						?><INPUT name="<? echo "var_" . $accion . "[_id_usuario]" ?>" type="hidden" value="<? 
						if($accion == "agregar"){ echo $id_usuario; }else{ echo $row["_id_usuario"]; } ?>"><?	 
				break;
	}
}
} ?>        
  </TABLE>
</FORM>
<CENTER>
  <? if (isset($include)){ ?>
  <P><A href="javascript:history.back();">VOLVER</A> 
    <? }else{ ?>
    <A href="javascript:window.close();">CERRAR</A> 
    <? } ?>
  </P>
</CENTER>