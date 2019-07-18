<SCRIPT>
function lim(obj, li){
	if(obj.value.length >= li){
		alert('Llegó al límite de caracteres (' + li + ') que\n permite este campo');
		event.returnValue=false;
	}
}
</SCRIPT>
<?
//##################### COLOCO TIPO DE CAMPO EN FORM #######################
function tipo_campo($accion, $query, $Campo, $row, $base){
global $deshabilitar_abm;
	$nombre_campo = mysql_field_name($query,$Campo);
	$tipo_campo = mysql_field_type($query,$Campo);
	if ($accion == "agregar" || $row=="" || !isset($row[$nombre_campo])){$variable_referencia = "";}else{$variable_referencia = stripslashes($row[$nombre_campo]);}
	if ($accion == "agregar_buscada"){ $accion = "agregar";}
	if ($accion == "borrar" || ( ( isset($deshabilitar_abm) &&  $deshabilitar_abm!="") && strstr(",".$deshabilitar_abm.",", ",".$nombre_campo.",")!=false )		){$opacar="DISABLED";}else{$opacar="";}
	
	if (substr($nombre_campo, 0, 3) == "id_" || substr($nombre_campo, 0, 4) == "_id_"){
		$supuesto_tabla = explode("_", $nombre_campo); // ej: id_sectores para referenciar a tabla usuarios_sectores
		$lista_tablas = mysql_list_tables ($base);
		
		for($x=count($supuesto_tabla)-1 ; $x>=0 ; $x--) {
			for($i=0; $i < mysql_num_rows($lista_tablas); $i++) {
				if ( strstr(	mysql_tablename($lista_tablas, $i), strtolower($supuesto_tabla[$x]) ) ) {
					$nombre_tabla = mysql_tablename($lista_tablas, $i);
					break;
				}
			}
			if (isset($nombre_tabla)){break;}
		}
		
		if($listo_campos = @mysql_list_fields($base, $nombre_tabla)){
		
			if(strstr($nombre_tabla,"foto")){$strQuery_secundario_orden = "id DESC LIMIT 30";}else{$strQuery_secundario_orden = "2 ASC";}
			$strQuery_secundario = "SELECT * FROM " . $nombre_tabla . " ORDER BY " . $strQuery_secundario_orden;
			$result_secundario = mysql_query($strQuery_secundario); ?>
<TABLE width="100%" border="0" cellspacing="0" cellpadding="0">
  <TR>
    <TD width="90%"><? $agregar_opcion=true ?>
<SELECT name="<? echo "var_" . $accion . "[" .$nombre_campo . "]" ?>" <? echo $opacar ?> style="width:100%">
        <OPTION value="">&nbsp;</OPTION>
        <? if (mysql_num_rows($result_secundario)!=0){ 
				While ($row_secundario = mysql_fetch_array($result_secundario)){ ?>
        <OPTION value="<? echo $row_secundario[0] ?>" <? if($row_secundario[0]==$variable_referencia){echo 'SELECTED';$agregar_opcion=false;} ?>><? echo $row_secundario[1] ?></OPTION>
        <?		}
			} 
		if($agregar_opcion){
			$result_agregar_opcion = mysql_query("SELECT * FROM " . $nombre_tabla . " WHERE id=" . $variable_referencia);
			if(mysql_num_rows($result_agregar_opcion)!=0){
				$row_agregar_opcion = mysql_fetch_array($result_agregar_opcion);
				?><OPTION value="<? echo $variable_referencia ?>" SELECTED><? echo $row_agregar_opcion[1] ?></OPTION><?
			}
		}
		?>
      </SELECT>
	  <!-- <INPUT type="text" name="<? echo "s_var_" . $accion . "[" .$nombre_campo . "]" ?>" value="" style="display:none"> -->
	  </TD>
    <? if ($accion != "buscar"){ ?>
    <TD width="5%" align="center">
      <INPUT name="agregar_vinculado" type="button" class="bot" style="font-size:8px; font-weight:bold" onClick="javascript: agregarVinculado('<? echo $nombre_tabla ?>')" value="+"></TD>
    <TD width="5%" align="center"> 
	 <INPUT name="seleccionar" type="button" class="bot" id="seleccionar" onClick="javascript:abrirVentana('ow_frame.php?tabla=<? echo $nombre_tabla ?>&include=vertabla&saltoPagina=uno&back_campo=<? echo "var_" . $accion . "[" .$nombre_campo . "]" ?>', 'seleccionar', 600, 400);" value="Seleccionar">
	  </TD>
    <? } ?>
  </TR>
</TABLE>
<?		}	
	} elseif (substr($nombre_campo, 0, 8) == "archivo_"){  
		?>
<TABLE width="100%" border="0" cellpadding="0" cellspacing="0">
  <TR> 
    <? if ($accion != "buscar"){ ?>
    <TD width="50%"> <INPUT  type="file" name="<? echo $nombre_campo ?>" value="<? echo $variable_referencia ?>" <? echo $opacar ?>  style="width:100%"></TD>
    <? } ?>
    <TD width="50%"> <SELECT name="<? echo "var_" . $accion . "[" .$nombre_campo . "]" ?>" style="width:100%"  <? echo $opacar ?>>
        <OPTION value="">&nbsp;</OPTION>
        <?
		$nombre_carpeta = substr($nombre_campo, 8, strlen($nombre_campo));
		$handle=opendir('clipart/'.$nombre_carpeta);
      				while ($file = readdir($handle)) { 
	  					if (strlen($file)>>2){
		  		?>
        <OPTION value="<? echo $file ?>" <? if ($variable_referencia == $file){echo 'SELECTED';} ?>><? echo $file ?></OPTION>
        <? 	}
	    			}
       			closedir($handle); 
	   			?>
      </SELECT></TD>
  </TR>
</TABLE>
<?
	}elseif (substr($nombre_campo, 0, 5) == "clave"){ #password
		if($accion=="modificar"){?><SCRIPT language="JavaScript">alert("Por favor llene nuevamente la contraseña\n para confirmar los cambios");</SCRIPT><? } ?>
		<INPUT type="password" name="<? echo "var_" . $accion . "[" .$nombre_campo . "]" ?>" value="" <? echo $opacar ?> style="width:100%"  onKeyPress="lim(this,<? echo mysql_field_len($query,$Campo) ?>)">
		<?
	}elseif (substr($nombre_campo, 0, 3) == "ck_"){ #checkbox
		?>
<INPUT type="checkbox" name="<? echo "var_" . $accion . "[" .$nombre_campo . "]" ?>" value="1" <? if ($variable_referencia==1){echo 'CHECKED';}?> <? echo $opacar ?>>
<?
	}elseif ($tipo_campo =="blob" && $accion!="buscar"){
?>
<!--<object id="<? echo $nombre_campo ?>" style="BACKGROUND-COLOR: buttonface" data="includes/rte/richedit.html" width="100%" height="250px" type="text/x-scriptlet" VIEWASTEXT>
</object>-->
<TEXTAREA name="<? echo "var_" . $accion . "[" .$nombre_campo . "]" ?>" rows="8" class="textarea" <? echo $opacar ?> ><? echo $variable_referencia ?></TEXTAREA>
<!--	<SCRIPT language="JavaScript" event="onload" for="window">
		<? echo $nombre_campo ?>.options = "history=no;source=yes";
		<? echo $nombre_campo ?>.docHtml = forms[0].<? echo "var_" . $accion . "[" .$nombre_campo . "]" ?>.innerText;
	</SCRIPT>
		<SCRIPT language="JavaScript" event="onscriptletevent(name, eventData)" for="richedit">
		if (name == "post") {
			forms[0].<? echo "var_" . $accion . "[" .$nombre_campo . "]" ?>.value = eventData;
			forms[0].submit();
		}
	</SCRIPT> -->
<?
	}elseif ($tipo_campo =="date" || $tipo_campo =="datetime"){
		?>
<TABLE border="0" cellspacing="0" cellpadding="0">
  <TR> 
    <TD><SELECT name="<? echo "var_" . $accion . "[" .$nombre_campo . "_dia]" ?>" <? echo $opacar ?>>
        <OPTION value="">&nbsp;</OPTION>
        <? for($d=1;$d<=31;$d++){ ?>
        <OPTION value="<? if($d<=9){echo '0';}; echo $d ?>" <? if ( ($accion == "agregar" && $d == date("d")) || $d == substr($variable_referencia,8,2) ){echo 'SELECTED';} ?>><? echo $d ?></OPTION>
        <? } ?>
      </SELECT></TD>
    <TD><SELECT name="<? echo "var_" . $accion . "[" .$nombre_campo . "_mes]" ?>" <? echo $opacar ?>>
        <OPTION value="">&nbsp;</OPTION>
        <? for($m=1;$m<=12;$m++){ ?>
        <OPTION value="<? if($m<=9){echo '0';}; echo $m ?>" <? if ( ($accion == "agregar" && $m == date("m")) || $m == substr($variable_referencia,5,2) ){echo 'SELECTED';} ?>><? echo $m ?></OPTION>
        <? } ?>
      </SELECT></TD>
    <TD><SELECT name="<? echo "var_" . $accion . "[" .$nombre_campo . "_anio]" ?>" <? echo $opacar ?>>
        <OPTION value="">&nbsp;</OPTION>
        <? for($a=1930;$a<=date('Y')+4;$a++){ ?>
        <OPTION value="<? echo $a ?>" <? if ( ($accion == "agregar" && $a == date("Y")) || $a == substr($variable_referencia,0,4) ){echo 'SELECTED';} ?>><? echo $a ?></OPTION>
        <? } ?>
      </SELECT></TD>
  </TR>
</TABLE>
<?
	} else{
		?>
<TEXTAREA  rows="1"  name="<? echo "var_" . $accion . "[" .$nombre_campo . "]" ?>" <? echo $opacar ?> style="width:100%" onKeyPress="lim(this,<? echo mysql_field_len($query,$Campo) ?>)"><? echo $variable_referencia ?></TEXTAREA>
<?
	}
}
//###########################LEYENDA DE CAMPOS#######################
function leyenda_campo($query,$Campo){
	$nombre_campo = mysql_field_name($query,$Campo); 
	$tipo_campo = mysql_field_type($query,$Campo);
	
	if (substr($nombre_campo, 0, 3) == "ck_" || substr($nombre_campo, 0, 3) == "id_" || substr($nombre_campo, 0, 8) == "archivo_"){
		$nombre_campo = substr($nombre_campo, strpos($nombre_campo,"_"));
	}
	
	echo strtoupper(str_replace("_", " ",$nombre_campo));
}
//###########################LEYENDA DE CONTENIDOS#######################
function leyenda_contenidos($row,$query,$Campo, $base){
	global $leyenda_extendida, $mostrar_imagen;
	$limite_caracteres = 30;
	$nombre_campo = mysql_field_name($query,$Campo); 
	$tipo_campo = mysql_field_type($query,$Campo);
	
	if (substr($nombre_campo, 0, 3) == "id_" || substr($nombre_campo, 0, 4) == "_id_"){
		$supuesto_tabla = explode("_", $nombre_campo); // ej: id_sectores para referenciar a tabla usuarios_sectores
		$lista_tablas = mysql_list_tables ($base);
		
		for($x=count($supuesto_tabla)-1 ; $x>=0 ; $x--) {
			for($i=0; $i < mysql_num_rows($lista_tablas); $i++) {
				if ( strstr(	mysql_tablename($lista_tablas, $i), $supuesto_tabla[$x] ) ) {
					$nombre_tabla = mysql_tablename($lista_tablas, $i);
					break;
				}
			}
			if (isset($nombre_tabla)){break;}
		}
		$strQuery_secundario = "SELECT * FROM " . $nombre_tabla . " WHERE id=" . $row[$Campo];
		if($result_secundario = mysql_query($strQuery_secundario)){
			$row_secundario = mysql_fetch_array($result_secundario);
			
			if(!$leyenda_extendida && strlen($row_secundario[1])>=$limite_caracteres){
				echo substr($row_secundario[1], 0, $limite_caracteres) . "...";
			}else{
				echo $row_secundario[1];
			}
			
			if( $mostrar_imagen && $nombre_tabla == "fotos" && $row_secundario["archivo_imagen"]!=""){
				?><BR>
				<IMG src="clipart/imagen/<? echo $row_secundario["archivo_imagen"]?>"><?
			}
		
		}else{ 
			echo "&nbsp;";
		}
	}elseif (substr($nombre_campo, 0, 3) == "ck_"){
		?>
<CENTER>
  <INPUT type="checkbox" name="ck_<? echo $nombre_campo ?>[<? echo $row["id"]; ?>]" value="1" <? if ($row[$Campo]==1){echo 'CHECKED';}?>>
</CENTER>
<?
	}elseif(!$leyenda_extendida && strlen($row[$Campo])>=$limite_caracteres){
		echo substr(stripslashes($row[$Campo]), 0, $limite_caracteres) . "...";
	}elseif ($tipo_campo =="date"){
		echo formato_fecha($row[$Campo]);
	}else{
		echo stripslashes($row[$Campo]);
	}
	
	if( $mostrar_imagen && $nombre_campo == "archivo_imagen" && $row[$Campo]!=""){
		?>
<BR>
<IMG src="clipart/imagen/<? echo $row[$Campo]?>">
<?
	}
}
//###########################FORMATO DE FECHA#######################
function formato_fecha($fecha){
	if($fecha!="Null" && $fecha!=""){
		$partes = explode("-", $fecha);
		if ((int) $partes[2] <= 9){ $dia = substr($partes[2], 1, 1);}else{ $dia = $partes[2];}
		if ((int) $partes[1] <= 9){ $mes = substr($partes[1], 1, 1);}else{ $mes = $partes[1];}
		$nueva_forma = $dia . "/" . $mes . "/" . $partes[0];
		return $nueva_forma;
	}
}
?>