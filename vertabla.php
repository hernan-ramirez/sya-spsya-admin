<SCRIPT language="JavaScript">
<!-- modificacion de campo ck para valor cero, por HJR
function envio_de_form(){
	for (var i=0; i<document.formulario_tabla.length; i++){
		campo = document.formulario_tabla.elements[i] ;
		if( campo.type == "checkbox" && campo.checked != campo.defaultChecked ){
			if(campo.value == 1 && campo.status != true){
				campo.value = 0;
				campo.status = true;
			}
		}
	}
	document.formulario_tabla.submit();
}
function borrarSel(){
	if(confirm("\n\n\nEsta por Borrar los registros seleccionados\n\n\n")){
		return true;
	}else{
		return false;
	}
}
function seleccionarReg(id){
	if(parent.der != null){
	parent.der.location = "pre.php?tabla=<? echo $tabla ?>&base=<? echo $base ?>&back_campo=<? if(isset($back_campo)){ echo $back_campo;} ?>&id=" + id;
	}
}
//-->
</SCRIPT>
<LINK href="includes/estilos_admin.css" rel="stylesheet" type="text/css">
<FORM name="formulario_tabla" method="post" action="<? echo $PHP_SELF ?>?include=vertabla<? if(isset($back_campo)){ echo '&back_campo=' .$back_campo; } ?>">
<?
//######################VER TABLA######################
//*******************tomo propiedades de muestreo
/*$result = mysql_query("SELECT * FROM _preset WHERE tabla = '" . $tabla . "'");
if($result != false && mysql_num_rows($result)!=0){
	$row = mysql_fetch_array($result);
	$mostrar = $row["query"];*/
	if (!isset($mostrar_listado) || $mostrar_listado == ""){ 
		$mostrar_listado = " * "; 
	}else{
		$mostrar_listado = "id," . $mostrar_listado;
	}
/*}else{
	$mostrar = " * ";
}*/
//*******************chequeo
if(isset($chequear)){
	$variable = "ck_" . key($chequear);	
	if (isset($$variable)){
		while(list($clave, $valor) = each($$variable)){
			if (key($chequear)=="borrar"){
				$exe_chek = "DELETE FROM " . $tabla . " WHERE id=" . $clave;
			}else{
				$exe_chek = "UPDATE " . $tabla . " SET " . key($chequear) . "=" . $valor . " WHERE id=" . $clave;
			}
			mysql_query($exe_chek);
		}
	}else{ 
		echo "Usted no chekeó nada<BR>";
	}
}
$rango = 20; 
//######################QUERY######################
$strQuery = "SELECT " . $mostrar_listado . " FROM " . $tabla;
//----------buscardor
if(isset($buscar)){
	$strQuery .= " WHERE ";
?>
  <INPUT name="buscar" type="hidden" value="realizada">
  <?
  	$i = 1;
	$fecha_buscada = "";
	while (list($clave, $valor) = each ($var_buscar)) {
		if($valor!=""){
		if(strstr($clave, "_dia") || strstr($clave, "_mes") || strstr($clave, "_anio")){ 
			if(!strstr($clave, "_dia")){ $fecha_buscada = "-" . $fecha_buscada; }
			if($valor == ""){$fecha_buscada = "__" . $fecha_buscada;}
			$fecha_buscada = $valor . $fecha_buscada;
			if(strstr($clave, "_anio")){
				$campo_fecha = explode("_anio", $clave); 
				$strQuery .= " " . $campo_fecha[0] . " LIKE '%" . $fecha_buscada . "%' ";
				if ($i != count($var_buscar)){ $strQuery .= " AND ";}
			}
		}else{
			if(strstr($clave, "id_") && $valor!= ""){
				$strQuery .= " " . $clave . " = " . $valor ;
			}else{
				$strQuery .= " " . $clave . " LIKE '%" . $valor . "%'"; 
			}
			if ($i != count($var_buscar)){ $strQuery .= " AND ";}
		}
		}
		$i++;
	}
	if ( substr($strQuery,-5) == " AND " ){ $strQuery = substr($strQuery,0,strlen($strQuery)-5); }
}
$query = mysql_query($strQuery);
$rs_totales = mysql_num_rows($query);
$paginas_totales = ceil($rs_totales / $rango);
//######################PAGINACION######################
If (isset($salto_pagina)){
	switch ($salto_pagina) {
	    case "9": 
			$pagina = 1;
			break;
	    case "7": 
			$pagina = $num_pagina - 1;
			break;
	    case "8": 
			$pagina = $num_pagina + 1;
			break;
    	case ":": 
			$pagina = $paginas_totales;
			break;
	}
}else{
	If (!isset($num_pagina)){ 
		$pagina = 1;
	}else{
		$pagina = $num_pagina; 
	}
}
function botones_paginacion($pagina, $paginas_totales){
?>
  <TABLE border="0" cellpadding="1" cellspacing="1">
    <TR> 
      <TD> <INPUT type="submit" value="9" name="salto_pagina" class="botones" <? IF ($pagina == 1){echo "DISABLED";} ?>></TD>
      <TD> <INPUT type="submit" value="7" name="salto_pagina" class="botones" <? IF ($pagina == 1){echo "DISABLED";} ?>></TD>
      <TD><SELECT name="num_pagina" onChange="document.formulario_tabla.submit()">
          <? for($i=1;$i<=$paginas_totales;$i++){ ?>
          <OPTION value="<? echo $i ?>" <? if($pagina==$i){ echo 'SELECTED';} ?>><? echo $i ?></OPTION>
          <? } ?>
        </SELECT></TD>
      <TD> <INPUT type="submit" value="8" name="salto_pagina" class="botones" <? IF ($pagina == $paginas_totales){echo "DISABLED";} ?>></TD>
      <TD> <INPUT type="submit" value=":" name="salto_pagina" class="botones" <? IF ($pagina == $paginas_totales){echo "DISABLED";} ?>></TD>
    </TR>
  </TABLE> <? 
}
   
$rs_inicio = ($pagina * $rango) - $rango;
//######################ARMO QUERY######################
//----------orden
if(isset($ordenar)){	
	$variable_orden = key($ordenar);
	if ($ordenado_forma=="DESC"){$ordenado_forma="ASC";}else{$ordenado_forma="DESC";}
}elseif(isset($ordenado)){
	$variable_orden = $ordenado;
}else{
	$variable_orden = mysql_field_name(mysql_list_fields($base, $tabla), 0);
	$ordenado_forma = "DESC";
}
$strQuery .= " ORDER BY " . $variable_orden . " " . $ordenado_forma . " ";
?>
  <INPUT name="ordenado" type="hidden" id="tabla" value="<? echo $variable_orden ?>">
  <INPUT name="ordenado_forma" type="hidden" id="tabla" value="<? echo $ordenado_forma ?>">
  <?
//-----------paginacion
$strQuery .= " LIMIT " . $rs_inicio . "," . $rango;
$query = mysql_query($strQuery);
$cantidad_records = mysql_num_rows($query);
$cantidad_campos = mysql_num_fields($query);
#echo $strQuery;
//######################VOLCADO######################
?> 
  <INPUT name="tabla" type="hidden" id="tabla" value="<? echo $tabla ?>">
  <INPUT name="base" type="hidden" id="tabla" value="<? echo $base ?>">
  <TABLE width="100%" height="27" border="0" cellpadding="2" cellspacing="0" class="BackTitleFirst">
    <TR> 
	 		<TD height="27"><FONT color="#FFFFFF">&nbsp; <b><? echo strtoupper($tabla) ?></b></FONT></TD>
    </TR>
        
  </TABLE>
        
  
  <TABLE width="100%" border="0" cellspacing="0" cellpadding="0">
    <TR>
	  
	 <TD class="BackVioletWorkFrame">&nbsp;</TD>
    </TR>
    <TR>
	  <TD class="BackVioletWorkFrame"> 
        <TABLE width="100%" border="0" cellpadding="0" cellspacing="0">
          <TR> 
            <TD width="2"><IMG src="image/frame_work_start.gif" width="2" height="33"></TD>
            <TD width="100%" class="BackFrameWork"><TABLE width="100%" border="0" cellspacing="0" cellpadding="0">
                <TR> 
                  <TD><TABLE width="100" border="0" cellspacing="0" cellpadding="0">
                      <TR> 
                        <TD nowrap><? echo $cantidad_records ?> Documentos de  <? echo $rs_totales ?></TD>
                        <TD><IMG src="image/spacer.gif" width="4" height="1"></TD>
                        <TD><IMG src="image/spacer.gif" width="4" height="4"></TD>
	    
                        <TD><IMG src="image/pipe.gif" width="2"></TD>
                        <TD><IMG src="image/spacer.gif" width="8" height="1"></TD>
                        <TD><? botones_paginacion($pagina, $paginas_totales);  ?></TD>
                        <TD><IMG src="image/spacer.gif" width="8" height="1"></TD>
                        <TD><IMG src="image/pipe.gif" width="2"></TD>
                        <TD><IMG src="image/spacer.gif" width="8" height="1"></TD>
                        <TD><INPUT name="Agregar" type="submit" class="BtnAgregarOff" id="Agregar" onMouseOver="this.className='BtnAgregarOver';" onMouseOut="this.className='BtnAgregarOff';" value="" onClick="document.formulario_tabla.action='?accion=agregar&include=abm';"></TD>
                        <TD><INPUT name="chequear[borrar]" type="submit" class="BtnEliminarOff" value="" onMouseOver="this.className='BtnEliminarOver';" onMouseOut="this.className='BtnEliminarOff';" onClick="return borrarSel()"></TD>
                        <TD><IMG src="image/spacer.gif" width="8" height="1"></TD>
                        <TD><IMG src="image/pipe.gif" width="2"></TD>
                        <TD><IMG src="image/spacer.gif" width="8" height="1"></TD>
                      </TR>
                    </TABLE></TD>
                  <TD>&nbsp;</TD>
                </TR>
              </TABLE></TD>
            <TD width="2"><IMG src="image/frame_work_end.gif" width="2" height="33"></TD>
          </TR>
        </TABLE></TD>
    </TR>
    <TR>
	 <TD class="BackVioletWorkFrame">&nbsp;</TD>
    </TR>
  </TABLE>
  
  <TABLE width="100%" border="0" cellspacing="1" cellpadding="0">
          
    <TR> 
            
      <TD width="15" align="center" class="HeaderContenido">M</TD>
      <TD width="15" align="center" class="HeaderContenido">x</TD>
      <TD width="15" align="center" class="HeaderContenido">B</TD>
      <? FOR($Campo = 0; $Campo < $cantidad_campos; $Campo++){ 
				if(strstr(mysql_field_flags ($query, $Campo), "primary_key") != false){ $claves_primarias[$Campo] = mysql_field_name($query,$Campo); }
				if(mysql_field_name($query,$Campo)!="id"){ ?>
            
      <TD class="HeaderContenido"> 
              
        <TABLE border="0" cellspacing="0" cellpadding="0">
          <TR> 
                  
            <TD> 
               <FONT face="webdings" size="2" color="white">     
              <? if($variable_orden == mysql_field_name($query,$Campo)){ if($ordenado_forma=="ASC"){echo "5";}else{echo "6";}} ?>
					</FONT>
                    </TD>
            <TD>
              <INPUT name="ordenar[<? echo mysql_field_name($query,$Campo) ?>]" type="submit" class="SubmitHeader" value="<? leyenda_campo($query,$Campo) ?>">
            </TD>
          </TR>
              
        </TABLE>
      </TD>
      <?		} 
				} ?>
          </TR>
          
    <TR> 
            
      <TD colspan="3" align="center" bgcolor="#F0F0F0"> 
        <TABLE width="100%" border="0" cellspacing="0" cellpadding="0">
                
          <TR> 
                  
            <TD width="45">
              <INPUT name="buscar" type="submit" class="BackBuscar" style="background-color:#F0F0F0;cursor:hand; border:none" value="Buscar">
               
                  </TD>
            <TD width="15"><A href="?base=<? echo $base ?>&tabla=<? echo $tabla ?>&include=vertabla&saltopagina=uno">x</A></TD>
          </TR>
              
        </TABLE>
      </TD>
      <? FOR($Campo = 0; $Campo < $cantidad_campos; $Campo++){ 
					if(mysql_field_name($query,$Campo)!="id"){ ?>
            
      <TD align="center" class="Celeste"> 
              
        <? if(isset($var_buscar)){$varr=$var_buscar;}else{$varr="";};tipo_campo("buscar", $query, $Campo, $varr, $base); ?>
            </TD>
      <? 	}
				} ?>
          </TR>
          
    <?
IF($cantidad_records!=0){
	 $Registro = 0;
	 $estilo_row = "Blanco";
		WHILE($row=mysql_fetch_array($query)){ 
	 		if($estilo_row == "Blanco"){$estilo_row = "Celeste";}else{$estilo_row = "Blanco";}
          ?>
    <TR> 
            
      <TD width="20" valign="top" class="<? echo $estilo_row ?>_b">
        <INPUT name="modificar" type="submit" class="BotEditar" title="Modifica este registro" onClick="document.formulario_tabla.action=<? 
			  echo "'?accion=modificar&" ;
			  for($i=0; $i<count($claves_primarias); $i++){
			  	echo $claves_primarias[0] . "=" . $row[$claves_primarias[0]]. "&";
			  }
			  echo "include=abm';";
			   ?>" value="" >
      </TD>
      <TD width="20" valign="top" class="<? echo $estilo_row ?>_b">
              
        <INPUT type="checkbox" name="ck_borrar[<? echo $row["id"]; ?>]" value="<? echo $row["id"]; ?>">
      </TD>
      <TD width="20" valign="top" class="<? echo $estilo_row ?>_b">
        <INPUT name="borrar" title="Borra este registro"  type="submit" value="x"  class="BotBorrar" onClick="document.formulario_tabla.action=<? 
			  echo "'?accion=borrar&" ;
			  for($i=0; $i<count($claves_primarias); $i++){
			  	echo $claves_primarias[0] . "=" . $row[$claves_primarias[0]]. "&";
			  }
			  echo "include=abm';";
			   ?>">
      </TD>
      <? FOR($Campo = 0; $Campo < $cantidad_campos; $Campo++){ 
					if(mysql_field_name($query,$Campo)!="id"){ ?>
            
      <TD class="<? echo $estilo_row ?>" onClick="seleccionarReg(<? echo $row["id"] ?>);"> 
              
        <? leyenda_contenidos($row,$query,$Campo, $base) ?>
            </TD>
      <?	 }
				}
		$Registro++;
		}
		?>
          </TR>
          
    <TR> 
            
	  <TD colspan="3" align="center">&nbsp;</TD>
      <? FOR($Campo = 0; $Campo < $cantidad_campos; $Campo++){ 
				if(mysql_field_name($query,$Campo)!="id"){ ?>
            
      <TD align="center"> 
              
        <? if(substr(mysql_field_name($query,$Campo), 0, 3) == "ck_"){ ?>
              
        <INPUT name="chequear[<? echo mysql_field_name($query,$Campo) ?>]" type="submit" class="Celeste" style="cursor:hand" onClick="envio_de_form()" value="<? echo strtoupper(substr(mysql_field_name($query,$Campo),3)) ?>">
         
              
        <? }else{ ?>
              &nbsp; 
              
        <? } ?>
            </TD>
      <? }
			 } ?>
          </TR>
          
    <?
}ELSE{
	echo "<FONT size=2 color=#FF0000><B>No se ha encontrado ningún registro</B></FONT>";
}
?>
  </TABLE>
</FORM>

