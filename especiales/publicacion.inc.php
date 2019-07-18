<?
#######################
$result = mysql_query("SELECT id FROM usuarios_lista_tablas WHERE tabla = '$tabla' ");
if (mysql_num_rows($result)){
	$row = mysql_fetch_array($result);
	$id_lista_tablas = $row["id"]; 
}
#######################
include "common/estructura.fnc.php";
if(isset($id)){ 
$accion = "" ;
if(isset($agregar) && $id_estructura!="" && isset($id)){
	############### TOMO LAS PROPIEDADES DE LAS SECCIONES ###########
	$sql = "SELECT * FROM secciones WHERE id_lista_tablas = $id_lista_tablas";
	$result = mysql_query($sql);
	if(mysql_num_rows($result)!=0){
		while ($row = mysql_fetch_array($result)){
			$id_secc = $row["id"];
			$seccion[$id_secc]["orden"] = $row["orden"];
			$seccion[$id_secc]["cantidad"] = $row["cantidad"];
		}
	}
	if ($seccion[$id_seccion]["orden"]==""){ 
		$seccion[$id_seccion]["orden"]="NULL";
		$remplaza = "si";
	}
	
if (!isset($remplaza)){
	########### EFECTO  CASCADA ####################
	$sql = "SELECT p.id, p.posicion, s.cantidad, s.orden, p.id_seccion  
	FROM publicaciones p , secciones s 
	WHERE p.id_seccion = s.id
	AND p.id_estructura = $id_estructura 
	AND p.id_lista_tablas = $id_lista_tablas 
	AND s.id_lista_tablas = $id_lista_tablas
	
	AND(
		(s.orden = ".$seccion[$id_seccion]["orden"]." AND p.posicion >= $posicion )
		OR s.orden > ".$seccion[$id_seccion]["orden"]."
	) 
	ORDER BY s.orden, p.posicion"; # Selecciones los registros de abajo en el orden 
	
	$mirar_acciones = "<pre>" . $sql . "</pre>";
	$cont = 0;
	$result = mysql_query($sql);
	if(mysql_num_rows($result)!=0){
		while ($row = mysql_fetch_array($result)){ # los recorro
			$cont ++;
			
			$mirar_acciones .=  "El registro: " . $row["id"] . " 
			Pasa a la posicion: " . ($row["posicion"] + 1) ."@ 
			Si es MENOR al limite @ ". $row["cantidad"] . "<BR>";
			if (($row["posicion"] + 1) > $row["cantidad"]){ 
				# si la nueva pos es > al limite de la seccion
			 
				$sql_p = "SELECT id FROM secciones 
				WHERE id_lista_tablas = $id_lista_tablas AND orden > " . $row["orden"] . " ORDER BY orden ASC LIMIT 1" ; 
				$result_p = mysql_query($sql_p);
				if( mysql_num_rows($result_p)!=0 ){ 
					# Si existe la siguiente seccion,		# 
					# actualiza la secc y vuelve a 1 la pos #
				
					$row_p = mysql_fetch_array($result_p);
					$sql_up = "UPDATE publicaciones 
					SET posicion = 1 , id_seccion = ".$row_p["id"]." 
					WHERE id = ". $row["id"];
					
					$sql_check = "SELECT id FROM publicaciones 
					WHERE id_lista_tablas = $id_lista_tablas 
					AND id_estructura = $id_estructura  
					AND posicion = 1 
					AND id_seccion = ".$row_p["id"]; 
					
					$result_check = mysql_query($sql_check);
					$CHECK = mysql_num_rows($result_check);
					
					$mirar_acciones .= "%%%%%" .$sql_check. "%%<font color=yellow>".$CHECK."</font>%%%<BR>" ;
					
					if (mysql_query($sql_up)){ 
						$mirar_acciones .= "Pero es MAYOR y 
						Existe la siguiente seccion, actualiza la seccion a 
						". $row_p["id"] . " y vuelve a 1 la posicion
						<BR>------#".$cont."#" . $sql_up . "#-------<BR><BR>"; 
					}
					
					if($CHECK === 0){
						$mirar_acciones .= "<BR><font color=yellow>!!! Corto el proceso 
						por que se lleno un HUECO !!!</font><BR> ";
						break;
					}
					unset($CHECK);
				}else{ 
					# sino , borro el registro, que seria el ultimo que se pierde
					$sql_del = "DELETE FROM publicaciones 
					WHERE id = ". $row["id"];
					if ( mysql_query($sql_del) ){ 
						$mirar_acciones .= "Pero es MAYOR y no existe la siguiente 
						seccion. => Borro el registro, que seria el ultimo que se 
						pierde<BR>------#".$cont."#" . $sql_del . "#-------<BR><BR>";
					}
				}
				
			}else{ 
				# Actualizo el reg a la new pos , pos+1
				$sql_up = "UPDATE publicaciones 
				SET posicion =".($row["posicion"] + 1)." WHERE id = ". $row["id"];
				
				$sql_check = "SELECT id FROM publicaciones 
				WHERE posicion =".($row["posicion"] + 1)." 
				AND id_lista_tablas = $id_lista_tablas 
				AND id_estructura = $id_estructura 
				AND id_seccion = ".$row["id_seccion"];
				$result_check = mysql_query($sql_check);
				$CHECK = mysql_num_rows($result_check);
				
				$mirar_acciones .= "%%%%%" .$sql_check. "%%<font color=yellow>".$CHECK."</font>%%%<BR>" ;
				
				if ( mysql_query($sql_up) ){ 
					$mirar_acciones .= "Actualizo el registro " . $row["id"] . " 
					a la nueva posicion , " . ($row["posicion"] + 1) . "
					<BR>------#".$cont."#" . $sql_up . "#-------<BR><BR>"; 
				}
				
				if($CHECK===0){
					$mirar_acciones .= "<BR><font color=yellow>!!! Corto el proceso 
						por que se lleno un HUECO !!!</font><BR> ";
					break;
				}
				
			} # del if
			
 		}# del while 
	}# del if
} # fin del remplaza
if (isset($remplaza)){
	mysql_query("DELETE FROM publicaciones WHERE id_lista_tablas = $id_lista_tablas AND `id_estructura`= $id_estructura  AND  `id_seccion`= $id_seccion AND `posicion` = $posicion");
}	
	#echo $mirar_acciones ; ## IMPRIMO ACCIONES 	
	############### INSERTO ###########
	mysql_query("INSERT INTO `publicaciones` ( id_lista_tablas, `id_publicado` , `id_estructura` ,  `id_seccion` , `posicion`  ) 
		VALUES ('$id_lista_tablas', '$id', '$id_estructura', '$id_seccion', '$posicion');");
}
if(isset($borrar)){
	mysql_query("DELETE FROM publicaciones WHERE id=". key($borrar));
}
?>
<SCRIPT>
function restablecerPosicion(){
	ob = window.document.forms[0].id_seccion;
	valor = ob.options[ob.selectedIndex].id;
	
	list = window.document.forms[0].posicion;
	//alert("aa " + list.length + " " + list.name);
	for (i = 0 ; i <= list.length + 2 ; i++){
		list.options[0] = null ;
		list.options.remove(0);			
	}
	
	for (i = 1 ; i <= valor ; i++){
		var opcion = window.document.createElement("OPTION");
		opcion.text = i;
		opcion.value = i;
		list.options.add(opcion);
	}
	
}
</SCRIPT>
<FORM name="relaciones" action="" method="post">
<? include "abm_header.php"; ?>
<INPUT type="hidden" name="tabla" value="<? echo $tabla ?>">
<INPUT type="hidden" name="id" value="<? echo $id ?>">
  <TABLE width="100%" border="0" cellspacing="0" cellpadding="0">
    <TR> 
      <TD width="80%" class="HeaderContenido" style="border-bottom: 1px #7B92AD solid; border-left: 1px #7B92AD solid">Ubicaci&oacute;n</TD>
	 <TD align="center" class="HeaderContenido" style="border-bottom: 1px #7B92AD solid; border-left: 1px #7B92AD solid">Secci&oacute;n</TD>
	 <TD align="center" class="HeaderContenido" style="border-bottom: 1px #7B92AD solid; border-left: 1px #7B92AD solid">Posici&oacute;n</TD>
	 <TD width="1%" align="center" class="HeaderContenido" style="border-bottom: 1px #7B92AD solid; border-left: 1px #7B92AD solid">Remplaza</TD>
	 <TD width="1%" class="HeaderContenido" style="border-bottom: 1px #7B92AD solid; border-left: 1px #7B92AD solid">&nbsp;</TD>
    </TR>
    <TR> 
    	 
	  <TD class="Celeste" style="border-bottom: 1px #7B92AD solid; border-left: 1px #7B92AD solid"> 
				<TABLE width="100%" border="0" cellspacing="0" cellpadding="0">
					<TR> 
						<TD width="70%">
							<INPUT name="txtUbicacion" type="text" id="txtUbicacion" style="width:100%">
						</TD>
						<TD>
							<INPUT name="sel_ubi" type="button"  class="bot" onClick="abrirVentana('especiales/ow.php?tabla=estructura&include=estructura&usuario_admin=<? echo $usuario_admin ?>&seleccionar=si&path=../','ubi','450','350')" value="Seleccionar" >
						</TD>
						<? if($tabla=="noticias"){ ?><TD><INPUT name="ver_huecos" type="button"  class="bot" onClick="abrirVentana('especiales/verificador.php?id_estructura='+document.forms[0].id_estructura.value,'ver','450','350')" value="Verificar"></TD><? } ?>
					</TR>
				</TABLE>
		<INPUT type="hidden" name="id_estructura" value=""></TD>
	 <TD align="center" class="Celeste" style="border-bottom: 1px #7B92AD solid; border-left: 1px #7B92AD solid"><SELECT name="id_seccion" id="id_seccion" onChange="javascript:restablecerPosicion();">
		<?  $result = mysql_query("SELECT * FROM secciones WHERE id_lista_tablas = $id_lista_tablas ORDER BY orden ASC");
			if(mysql_num_rows($result)!=0){
				while ($row=mysql_fetch_array($result)){
					if(!isset($cantidad_inicial)){ $cantidad_inicial = $row["cantidad"]; }
		?>
          <OPTION id="<? echo $row["cantidad"]?>" value="<? echo $row["id"]?>"><? echo $row["seccion"]?></OPTION>
		<? }
		}
		?>
        </SELECT></TD>
	 <TD align="center" class="Celeste" style="border-bottom: 1px #7B92AD solid; border-left: 1px #7B92AD solid"><SELECT name="posicion" id="posicion">
	 <? for ($i=1; $i<= $cantidad_inicial ; $i++){ ?>
	 	<OPTION value="<? echo $i ?>"><? echo $i ?></OPTION>
	 <? } ?>
	   </SELECT></TD>
	 <TD align="center" class="Celeste" style="border-bottom: 1px #7B92AD solid; border-left: 1px #7B92AD solid"><INPUT name="remplaza" type="checkbox" id="remplaza" value="si"></TD>
	 <TD class="Celeste" style="border-bottom: 1px #7B92AD solid; border-left: 1px #7B92AD solid"><INPUT type="submit" class="bot" name="agregar" value="Agregar"></TD>
    </TR>
  
		
    <?  $result = mysql_query("SELECT pu.*, s.seccion FROM publicaciones pu
		LEFT JOIN secciones  s ON (s.id = pu.id_seccion)
		WHERE 
		s.id_lista_tablas = $id_lista_tablas 
		AND pu.id_lista_tablas = $id_lista_tablas 
		AND id_publicado = $id ");
			if(mysql_num_rows($result)!=0){
				while ($row=mysql_fetch_array($result)){
		?>
    <TR>
    	 <TD class="Blanco" style="border-bottom: 1px #7B92AD solid; border-left: 1px #7B92AD solid">
	   <? 	 
	 $id_estructura =  $row["id_estructura"];
	 ubicacion();
	 echo $ubicacion["path"];
	 unset($ubicacion); 
	 ?>
	   	 
	 </TD>
	 <TD class="Blanco" style="border-bottom: 1px #7B92AD solid; border-left: 1px #7B92AD solid"><? echo $row["seccion"]?></TD>
	 <TD colspan="2" class="Blanco" style="border-bottom: 1px #7B92AD solid; border-left: 1px #7B92AD solid"><? echo $row["posicion"]?></TD>
	 <TD class="Blanco" style="border-bottom: 1px #7B92AD solid; border-left: 1px #7B92AD solid"><INPUT class="bot" name="borrar[<? echo $row["id"]?>]" type="submit" id="borrar" value="Borrar" style="width:100%"></TD>
    </TR>
		
    <? }
		}
		?>
  </TABLE>
</FORM>
<? } ?>

