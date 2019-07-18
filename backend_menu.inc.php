<TABLE width="165" border="0" cellspacing="0" cellpadding="0">
  <TR>
	<TD class="BackTitleFirst" align="center"><FONT color="#666666"><B><FONT color="#CED3FF">MEDIADEV C.M. V 0.1</FONT></B></FONT></TD>
  </TR>
</TABLE>
<TABLE border="0" align="left" cellpadding="0" cellspacing="0" ellspacing="0">
<TR>
	<TD>
	</TD>
  </TR>
  <?  
//################## DESPLIEGO TABLAS Y usuarios_sectores PERMITIDOS PARA EL USUARIO ############
if (!isset($tabla)){ $tabla="";}
if (!isset($almacen)){ $almacen="";}
function muestro_menu($row,$tabla,$almacen){
	
	if ($almacen != $row["sector"]){ 
		$almacen = $row["sector"] ?>
		
  <TR>
		  
    <TD class="BackMenu"><FONT title="<? echo $row['desSector'] ?>"><B>
			
      <? echo $row["sector"] ?>
			</B></FONT></TD>
  </TR>
<?
	} 
?>
	<TR<? if ($tabla == $row["nombre"]) { echo " bgcolor='#FFFFFF'"; } ?>>
	      
		<TD class="Submenu">&nbsp;&nbsp;		
		<A href="<?
		if($row["include"] != "") { $inc_men = $row["include"];}else{$inc_men = "vertabla";}
		if ($row["link"]!=""){
			echo stripslashes($row["link"]);
		}else{
			echo "index.php?tabla=" . $row["tabla"] . "&include=".$inc_men."&saltoPagina=uno";
		} 
		
		?>"><FONT title="<?=$row["descripcion"] ?>"<?
						
		if ($tabla == $row["nombre"]) { 
			echo " color='#FF0000'"; 
			$subir_archivos_a = $row["subir_archivos_a"];
		}elseif ($row["link"]!="") { 
			echo " color='#BBBBBB'"; 
		}
		
		?>>
				
		  <? echo str_replace("_", " ", $row["nombre"] )?>
				</FONT></A>
		</TD>
	</TR>
	    
  <? 
	return $almacen;
}
$sql = "SELECT lt.*, s.sector, s.descripcion AS desSector, p.*, pe.ck_admin
FROM usuarios_lista_tablas lt, usuarios_sectores s, usuarios_permisos p, usuarios u, usuarios_perfiles pe
WHERE lt.id_sectores = s.id 
	AND lt.id = p.id_tablas 
	AND p.id_perfil = u.id_perfil 
	AND pe.id = u.id_perfil
AND p.ck_activo = 1 
AND u.id = '" . $id_usuario . "' 
ORDER BY orden, nombre";
#echo "\n\n" . $sql . "<BR>\n\n"; 
$result = mysql_query($sql);
if (mysql_num_rows($result)!=0){
	while ($row=mysql_fetch_array($result)){
		if ($tabla == strtolower($row["tabla"]) ){ 
			$mostrar_listado = $row["mostrar_listado"];
			$deshabilitar_abm = $row["deshabilitar_abm"];
			$oculto_abm = $row["oculto_abm"];
			$usuario_admin = $row["ck_admin"];
		}	
		$almacen = muestro_menu($row,$tabla,$almacen);		
	}
}else{
	$sql = "SELECT t.*, s.sector, s.descripcion AS desSector  
	FROM usuarios_lista_tablas t, usuarios_sectores s 
	WHERE t.id_sectores = s.id 
	ORDER BY orden, nombre";
	//echo "\n\n" . $sql . "<BR>\n\n"; 
	$result = mysql_query($sql);
	while ($row=mysql_fetch_array($result)){
		$almacen = muestro_menu($row,$tabla,$almacen);		
	}
	$usuario_admin = $row["ck_admin"] = 1 ;
}
#echo $usuario_admin;
?>
<TR>
	<TD class="BackMenu"><A href="javascript:ejec_salir();"><FONT color="#FFFFFF">SALIR</FONT></A></TD>
</TR>
</TABLE>
<SCRIPT>
function ejec_salir(){
	alert("Para Salir tiene que cerrar esta ventana");
	window.close();
}
</SCRIPT>
