<?
if(!isset($path)){$path = "";}
include $path."especiales/common.inc.php";
if(isset($Submit) && is_array($estructura)){
	ejecutar("estructura");
}
if(isset($del_id)){
	mysql_query("DELETE FROM estructura WHERE id=".$del_id);
}
########### Formulario ############
?>
<SCRIPT>
<!--
function agregarSub(id){
	document.forms[0].elements[1].value = id;
	document.forms[0].action = document.forms[0].action + "?Submit=si";
	document.forms[0].submit();
}
function seleccionarUbi(id, nombre){
	opener.document.forms[0].id_estructura.value = id;
	opener.document.forms[0].txtUbicacion.value = nombre;
	window.close();
}
function cambiarBoton(id){
	document.all.maestro.style.display = "none";
	document.all.subordinado.style.display = "inline";
	document.all.subordinado.href = "javascript:agregarSub('" + id + "');";
}
//-->
</SCRIPT>
<LINK rel="stylesheet" href="../includes/estilos_admin.css" type="text/css">
<FORM name="" action="<? echo $PHP_SELF ?>" method="post" enctype="multipart/form-data">
<? if ($usuario_admin == "1"){ ?>
  <TABLE width="100%" border="0" cellspacing="0" cellpadding="0" >
	<TR >
		    <TD class="HeaderContenido">Edición</TD>
	</TR>
</TABLE>
    
  <TABLE width="100%" border="0" align="center" cellspacing="0">
	<INPUT type="hidden" name="estructura[id]">
	<INPUT type="hidden" name="estructura[id_estructura]">
	<TR class="Submenu"> 
	  <TD width="250">Nombre</TD>
	  <TD width="90%"> <INPUT type="text" name="estructura[nombre]" style="font-size:10px; width:100%"> 
	  </TD>
	</TR>
	<TR class="Submenu"> 
	  <TD>Link</TD>
	  <TD> <INPUT name="estructura[link]" type="text" style="font-size:10px; width:100%"> 
	  </TD>
	</TR>
	<TR class="Submenu"> 
	  <TD>Orden</TD>
	  <TD> <INPUT type="text" name="estructura[orden]" style="font-size:10px; width:50px"> 
	  </TD>
	</TR>
	<TR class="Submenu"> 
	  <TD>Tipo</TD>
	  <TD><SELECT name="estructura[tipo]">
		  <OPTION value="">&nbsp;</OPTION>
		  <OPTION value="1">Titulo</OPTION>
		  <OPTION value="2">Boton</OPTION>
		  <OPTION value="3">Lanzador</OPTION>
		  <OPTION value="4">Link</OPTION>
		  <OPTION value="5">Especiales</OPTION>
		</SELECT></TD>
	</TR>
	<TR class="Submenu">
	  <TD>Activo</TD>
	  <TD><SELECT name="estructura[ck_activa]">
		  <OPTION value="0">No</OPTION>
		  <OPTION value="1">Si</OPTION>
		</SELECT></TD>
	</TR>
	<TR class="Submenu"> 
	  <TD></TD>
	  <TD align="right"> <TABLE border="0" cellspacing="1" cellpadding="1" width="300">
		  <TR> 
			<TD width="50%" class="simBot"> <INPUT type="submit" name="Submit" id="maestro" value="Agregar"  class="bottexto" style="width:100%"> 
			  <A id="subordinado" href="" style="width:100%; display:none">Agregar 
			  SUB</A></TD>
			<TD width="50%"> <INPUT value="Cancelar" type="reset"  class="bot"  style="width:100%" onClick="javascript:document.forms[0].Submit.value='Agregar';" name="reset"> 
			</TD>
		  </TR>
		</TABLE></TD>
	</TR>
  </TABLE>
<? } ## del if si el $usuario_admin = 1 ?>
	 <INPUT type="hidden" name="include" value="<? echo $include ?>">	
	<INPUT type="hidden" name="tabla" value="<? echo $tabla ?>">	
	<INPUT type="hidden" name="path" value="<? echo $path ?>">	
	<? if(isset($seleccionar)){?><INPUT type="hidden" name="seleccionar" value="<? echo $seleccionar ?>">
	<? } ?>
    <?
########### Despliego La estructura  ################
?>
    <TABLE border="0" align="center" cellspacing="0" width="100%">
    <TR>
	 <TD colspan="4"  class="HeaderContenido">Estructura</TD>
    </TR>
    &nbsp;
    <? 
function impresion(){
	global $row, $espacios, $seleccionar,$path,$usuario_admin;	
	if($row["tipo"]=="0" || $row["tipo"]=="" || $row["tipo"]=="5"){$estilo = "celeste"; $ocultar="";}else{$estilo = "blanco"; $ocultar=" style='display:none'";}
	?>
    <TR class="<? echo $estilo ?>"<? if(isset($seleccionar)){ echo $ocultar;} ?>> 
	  
<? if ($usuario_admin == "1"){ ?>
	 <TD> <INPUT type="button" value="Modificar"  class="bot" 
	  onClick="javascript:modificar('<? echo $row["id"] ?>','<? echo $row["id_estructura"] ?>','<? echo $row["nombre"] ?>','<? echo $row["link"] ?>','<? echo $row["orden"]?>','<? echo $row["tipo"]?>','<? echo $row["ck_activa"]?>');document.forms[0].Submit.value='Modificar';"></TD>
<? } ?>
	 <TD width="100%" style="border-bottom: 1px #7B92AD solid; border-left: 1px #7B92AD solid">
	   <? if($espacios>0){  echo str_repeat ("&nbsp;", $espacios) . "<IMG src='".$path."image/flecha_azul.gif'>";} ?>
	   (<? echo $row["orden"] ?>)&nbsp;<A href=<?
	   
	   if(isset($seleccionar) && ($row["tipo"]=="0" || $row["tipo"]=="" || $row["tipo"]=="5") ){
	   	echo "'' title='Seleccionar Ubicación' onClick=\"javascript:seleccionarUbi('".$row['id']."', '".$row["nombre"]."')\" ";
		}else{
	   	#echo "javascript:abrirVentana('especiales/estructura_contenidos.php?id=". $row['id'] ."&nom_estructura=". $row["nombre"] ."','est_cont',350,400)  title='Editar Contenido' ";
			echo "'#'";
	   }
	   
	   ?>><? echo $row["nombre"] ?></A></TD>
<? if ($usuario_admin == "1"){ ?>
	 <TD><INPUT type="button" value="Agregar SUB"  class="bot" onClick="javascript:cambiarBoton('<? echo $row["id"]?>');"></TD>
	  <TD><INPUT type="button" value="Borrar"  class="bot" onClick="javascript:borrar('<? echo $row["nombre"] ?>','<? echo $row["id"] ?>')"></TD>
<? } ?>
    </TR>
    <? 
}
########### GERARQUIAS  ################
include $path."common/estructura.fnc.php";
$espacios = -6;
estructura();
?>
  </TABLE>
</FORM>

