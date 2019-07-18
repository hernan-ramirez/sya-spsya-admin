<!------------------------ COMIENZA FICHA PARTIDO ------------------------->
<? include "abm_header.php"; ?><?
if(isset($id)){
	$id_partido = $id; 
}else{
	#ejemplo 96
	$id_partido = 3; 
}
switch($accion){
	case "Agregar Cambio":
		$sale = $sale_primer;
		if ($sale ==""){$sale = $sale_segundo;}
		$entra = $entra_primer;
		if ($entra ==""){$entra = $entra_segundo;}
		mysql_query("INSERT INTO `futbol_cambios` (`id_partido`, `id_sale_jugador`, `id_entra_jugador`, `minuto`) 
		VALUES ('$id_partido', '$sale', '$entra', '$cambio_minuto');");
	break;
	case "Borrar Cambio":
		mysql_query("DELETE FROM `futbol_cambios` WHERE id = $id_registro;");
	break;
	############################
	case "Agregar Goleador":
		if ($goleador_primer ==""){
			$goleador = $goleador_segundo;
		}else{
			$goleador = $goleador_primer;
		}
		if ($goleador_primer ==""){
			if ($tipo_gol!="5"){
				mysql_query("UPDATE futbol_partidos SET goles_segundo_club = goles_segundo_club + 1 WHERE id = $id_partido;");
			}else{
				mysql_query("UPDATE futbol_partidos SET goles_primer_club = goles_primer_club + 1 WHERE id = $id_partido;");
			}
		}else{
			if ($tipo_gol=="5"){
				mysql_query("UPDATE futbol_partidos SET goles_segundo_club = goles_segundo_club + 1 WHERE id = $id_partido;");
			}else{
				mysql_query("UPDATE futbol_partidos SET goles_primer_club = goles_primer_club + 1 WHERE id = $id_partido;");
			}
		}
		mysql_query("INSERT INTO `futbol_goleadores` (`id_partido`, `id_jugador`, `id_tipo_goles`, `minuto`) 
		VALUES ('$id_partido', '$goleador', '$tipo_gol', '$gol_minuto');");
		## Sumo el gol en el partido
	break;
	case "Borrar Goleador":
		mysql_query("DELETE FROM `futbol_goleadores` WHERE id = $id_registro;");
		if ($id_registro_club =="segundo"){
			mysql_query("UPDATE futbol_partidos SET goles_segundo_club = goles_segundo_club - 1 WHERE id = $id_partido;");
		}else{
			mysql_query("UPDATE futbol_partidos SET goles_primer_club = goles_primer_club - 1 WHERE id = $id_partido;");
		}
	break;
	############################
	case "Agregar Tarjeta":
		$tarjeta_jugador = $tarjeta_jugador_primer;
		if ($tarjeta_jugador ==""){$tarjeta_jugador = $tarjeta_jugador_segundo;}
		mysql_query("INSERT INTO `futbol_tarjetas` (`id_partido`, `id_jugador`, `tarjeta`, `minuto`) 
		VALUES ('$id_partido', '$tarjeta_jugador', '$tarjeta', '$tarjeta_minuto');");
	break;
	case "Borrar Tarjeta":
		mysql_query("DELETE FROM `futbol_tarjetas` WHERE id = $id_registro;");
	break;
	############################
	case "Agregar Acción":
		mysql_query("INSERT INTO `futbol_acciones` (`id_partido`,`accion`, `descripcion`, `minuto`, `tiempo`) 
		VALUES ('$id_partido', '$accion_accion', '$accion_descripcion', '$accion_minuto', '$accion_tiempo');");
	break;
	case "Borrar Acción":
		mysql_query("DELETE FROM `futbol_acciones` WHERE id = $id_registro;");
	break;
	###########################
	case "Actualizar Formacion":
		if(is_array($orden)){
			while(list($id_jugador,$posicion) = each($orden)){
				if($posicion==""){
					mysql_query("DELETE FROM futbol_formacion WHERE id_jugador = $id_jugador");
				}else{
				$result_forma = mysql_query("SELECT id FROM futbol_formacion WHERE `id_partido`=$id_partido AND `id_jugador`=$id_jugador");
				if(mysql_num_rows($result_forma)!=0){
					mysql_query("UPDATE `futbol_formacion` 
					SET `orden`=$posicion
					WHERE `id_partido`=$id_partido AND `id_jugador`=$id_jugador");
				}else{
					$sql = "INSERT INTO futbol_formacion (id_partido, id_jugador, orden) 
					VALUES ($id_partido, $id_jugador, $posicion)";
					mysql_query($sql);
				}
				}
			}
		}
	break;
}

###################################
$sql = "
SELECT p.*, DATE_FORMAT(p.fecha_partido,'%e/%c/%y') AS fecha, t.torneo, c.nombre AS primer_club, cc.nombre AS segundo_club
FROM futbol_partidos p 
	LEFT JOIN futbol_torneos t ON (t.id = p.id_torneo)
	LEFT JOIN futbol_clubes c ON (c.id = p.id_primer_club)
	LEFT JOIN futbol_clubes cc ON (cc.id = id_segundo_club)
WHERE 
p.id = $id_partido
";
$result = mysql_query($sql);
if(mysql_num_rows($result)!=0){
	$row = mysql_fetch_array($result);
	$m = $row["id_primer_club"];
	$n = $row["id_segundo_club"];
	$estilo_club[$m] = "celeste";
	$estilo_club[$n] = "blanco";
	
	function desplegar_jugadores($nombre, $id_torneo, $id_club){
		########################## ARMO MATRIZ DE JUGADORES DEL PLANTEL DEL EQUIPO
		$sql = "
		SELECT j.nombre, j.apellido, j.numero, j.id
		FROM futbol_planteles p
			LEFT JOIN futbol_jugadores j ON (j.id = p.id_jugador)
		WHERE id_torneo = $id_torneo 
		AND id_clubes = $id_club
		ORDER BY id_clubes
		";
		#echo $sql;
		$result_jugadores = mysql_query($sql);
		##########################
		?><SELECT name="<? echo $nombre ?>"><OPTION value="">&nbsp;</OPTION>
		<? if(mysql_num_rows($result_jugadores)!=0){
		while ($row_jugadores = mysql_fetch_array($result_jugadores)){ 
			?><OPTION value="<? echo $row_jugadores["id"] ?>"><? echo $row_jugadores["numero"] ?>)&nbsp;<? echo $row_jugadores["apellido"] ?>&nbsp;<? echo $row_jugadores["nombre"] ?></OPTION>
		<? } } ?>
	  	</SELECT><?
	}
	
	
?>
<LINK href="../includes/estilos_admin.css" rel="stylesheet" type="text/css">
<BODY leftmargin="0" topmargin="0" marginwidth="0" marginheight="0"> 
<TABLE width="100%" cellpadding="0" cellspacing="0">
  <TR>
        <TD class="HeaderContenido">Detalle del partido :: Minuto a minuto</TD>
  </TR>
</TABLE>
<form name="partido" action="" method="post">
  <INPUT name="id_registro" type="hidden" id="id_registro">
  <INPUT name="id_registro_club" type="hidden" id="id_registro_club">
  <TABLE width="100%" border="0" cellpadding="0" cellspacing="1">
  <TR> 
	  <TD colspan="2" class="BackTitleFirst">Datos del Partido: </TD>
  </TR>
  <TR> 
	  <TD width="50" class="Celeste">Torneo</TD>
	<TD class="Celeste"><? echo $row["torneo"] ?></TD>
  </TR>
  <TR> 
	  <TD class="Blanco">N&uacute;mero</TD>
	<TD class="Blanco"><? echo $row["numero_partido"] ?></TD>
  </TR>
  <TR> 
	  <TD class="Celeste">Juegan</TD>
	  <TD class="Celeste"><? echo $row["primer_club"] ?>&nbsp;<b><? echo $row["goles_primer_club"] ?>&nbsp;-&nbsp;<? echo $row["goles_segundo_club"] ?></b>&nbsp; 
		<? echo $row["segundo_club"] ?></TD>
  </TR>
  <TR> 
	  <TD class="Blanco">Fecha</TD>
	<TD class="Blanco"><? echo $row["fecha"] ?></TD>
  </TR>
  <TR> 
	  <TD class="Celeste">Estadio</TD>
	<TD class="Celeste"><? echo $row["estadio"] ?></TD>
  </TR>
  <TR> 
	  <TD class="Blanco">Arbitro </TD>
	<TD class="Blanco"><? echo $row["arbitro"] ?></TD>
  </TR>
  <TR> 
	  <TD class="Celeste">Lineas</TD>
	<TD class="Celeste"><? echo $row["lineas"] ?></TD>
  </TR>
</TABLE>
  <TABLE width="100%" border="0" align="center" cellpadding="0" cellspacing="1">
	<TR bgcolor="#D7E3DB"> 
	  <TD colspan="2" class="BackTitleFirst"><STRONG>Formaciones [ <A href="#formas" onClick="javascript:document.all.tableta_formaciones.style.display='inline';">desplegar</A>]<A name="formas"></A></STRONG></TD>
	</TR>
	</table>
  <TABLE width="100%" border="0" align="center" cellpadding="0" cellspacing="1" id="tableta_formaciones" style="display:none">
	<TR align="center"> 
	  <TD width="50%" class="Celeste"><b><? echo $row["primer_club"] ?></b></TD>
	  <TD width="50%" class="Celeste"><b><? echo $row["segundo_club"] ?></b></TD>
	</TR>
	<? 
	$result_forma = mysql_query("SELECT * FROM futbol_formacion WHERE `id_partido`=$id_partido");
	if(mysql_num_rows($result_forma)!=0){
		while($row_forma = mysql_fetch_array($result_forma)){
			$i = $row_forma["id_jugador"];
			$orden[$i] = $row_forma["orden"];
		}
	}
	?>

	<TR align="center"> 
	  <TD class="Blanco">
	  <TABLE border="0" cellspacing="1" cellpadding="1"><?
	  			$sql = "
		SELECT j.nombre, j.apellido, j.numero, j.id
		FROM futbol_planteles p
			LEFT JOIN futbol_jugadores j ON (j.id = p.id_jugador)
		WHERE id_torneo = $row[id_torneo] 
		AND id_clubes = $row[id_primer_club]
		ORDER BY id_clubes
		";
	$result_jug = mysql_query($sql);
	if(mysql_num_rows($result_jug)){
		while($row_jug=mysql_fetch_array($result_jug)){
		$idjug = $row_jug["id"];
		 ?>
	<TR>
		<TD align="right"><? echo $row_jug["apellido"] . ", " . $row_jug["nombre"] ?></TD>
		<TD><INPUT name="orden[<? echo $idjug ?>]" value="<? echo $orden[$idjug] ?>" type="text" alt="Posición" style="width:20px"></TD>
	</TR>
<? }
} ?>
</TABLE>

	  </TD>
	  <TD class="Blanco">
				<TABLE border="0" cellspacing="1" cellpadding="1">
					<?
	  			$sql = "
		SELECT j.nombre, j.apellido, j.numero, j.id
		FROM futbol_planteles p
			LEFT JOIN futbol_jugadores j ON (j.id = p.id_jugador)
		WHERE id_torneo = $row[id_torneo] 
		AND id_clubes = $row[id_segundo_club]
		ORDER BY id_clubes
		";
	$result_jug = mysql_query($sql);
	if(mysql_num_rows($result_jug)){
		while($row_jug=mysql_fetch_array($result_jug)){
		$idjug = $row_jug["id"];
		 ?>
					<TR> 
						<TD align="right"><? echo $row_jug["apellido"] . ", " . $row_jug["nombre"] ?></TD>
						<TD>
							<INPUT name="orden[<? echo $idjug ?>]" value="<? echo $orden[$idjug] ?>" type="text" alt="Posición" style="width:20px">
						</TD>
					</TR>
					<? }
} ?>
				</TABLE>
			</TD>
	</TR>
	<TR> 
	  <TD colspan="2" align="center" class="Celeste"><INPUT name="accion" type="submit" class="bot" id="accion" value="Actualizar Formacion"></TD>
	</TR>
  </TABLE>
  <TABLE width="100%" border="0" align="center" cellpadding="0" cellspacing="1">
	<TR bgcolor="#D7E3DB"> 
	  <TD colspan="4" class="BackTitleFirst"><STRONG>Cambios</STRONG></TD>
	</TR>
	<TR> 
	  <TD width="300" class="BackRelaciones">Sale</TD>
	  <TD width="50%" class="BackRelaciones">Entra</TD>
	  <TD width="15" align="center" class="BackRelaciones">Minuto</TD>
	  <TD class="BackRelaciones">&nbsp;</TD>
	</TR>
	<? $sql = "SELECT c.id, c.minuto, j.apellido AS sale_apellido, j.nombre AS sale_nombre, 
			ju.apellido AS entra_apellido, ju.nombre AS entra_nombre, 
			j.numero AS sale_numero, ju.numero AS entra_numero , p.id_clubes
			FROM futbol_cambios c
		LEFT JOIN futbol_jugadores j ON (j.id = c.id_sale_jugador)
		LEFT JOIN futbol_jugadores ju ON (ju.id = c.id_entra_jugador)
		LEFT JOIN futbol_planteles p ON (p.id_jugador = j.id)
	WHERE id_partido = $id_partido
		AND ( p.id_clubes = $row[id_primer_club]
		OR p.id_clubes = $row[id_segundo_club] )
	ORDER BY c.minuto";
	$resultado = mysql_query($sql);
	if(mysql_num_rows($resultado)!=0){ 
		while($fila = mysql_fetch_array($resultado)){ 
		$m = $fila["id_clubes"]; 
		?>
	<TR> 
	  <TD class="<? echo $estilo_club[$m] ?>"><? echo $fila["sale_numero"] . ") " . $fila["sale_apellido"] . " " . $fila["sale_nombre"] ?></TD>
	  <TD class="<? echo $estilo_club[$m] ?>"><? echo $fila["entra_numero"] . ") " . $fila["entra_apellido"] . " " . $fila["entra_nombre"] ?></TD>
	  <TD class="<? echo $estilo_club[$m] ?>" align="center"><? echo $fila["minuto"] ?></TD>
	  <TD class="<? echo $estilo_club[$m] ?>"><INPUT name="accion" type="submit" class="bot" id="accion" onClick="javascript:document.all.id_registro.value=<? echo $fila["id"]?>" value="Borrar Cambio"></TD>
	</TR>
	<? } } ?>
	<TR> 
	  <TD><Div class="Celeste" widht="100%" cellspacing="1"> 
		<? desplegar_jugadores("sale_primer", $row["id_torneo"], $row["id_primer_club"]) ?>
		</div><Div class="Blanco" widht="100%" cellspacing="1">
		<? desplegar_jugadores("sale_segundo", $row["id_torneo"], $row["id_segundo_club"]) ?></div>
	  </TD>
	  <TD> <Div class="Celeste" widht="100%" cellspacing="1">
		<? desplegar_jugadores("entra_primer", $row["id_torneo"], $row["id_primer_club"]) ?>
		</div> <Div class="Blanco" widht="100%" cellspacing="1">
		<? desplegar_jugadores("entra_segundo", $row["id_torneo"], $row["id_segundo_club"]) ?></div>
	  </TD>
	  <TD align="center"><INPUT name="cambio_minuto" type="text" id="cambio_minuto" size="6" maxlength="3"> 
	  </TD>
	   <td>&nbsp;</td>
	</TR>
	<TR> 
	  <TD colspan="4" align="center" class="Celeste"><INPUT name="accion" type="submit" class="bot" id="accion" value="Agregar Cambio"></TD>
	</TR>
  </TABLE>
  <TABLE width="100%" border="0" align="center" cellpadding="0" cellspacing="1">
	<TR bgcolor="#D7E3DB"> 
	  <TD colspan="4" class="BackTitleFirst"><STRONG>Goleadores</STRONG></TD>
	</TR>
	<TR> 
	  <TD width="300" class="BackRelaciones">Jugador </TD>
	  <TD width="50%" class="BackRelaciones">Tipo</TD>
	  <TD width="10" align="center" class="BackRelaciones">Minuto</TD>
	  <td class="BackRelaciones">&nbsp;</td>
	</TR>
<?
$sql = "SELECT g.id, g.minuto, j.apellido, j.nombre, 
j.numero, t.tipo, p.id_clubes
FROM futbol_goleadores g
	LEFT JOIN futbol_jugadores j ON (j.id = g.id_jugador)
	LEFT JOIN futbol_planteles p ON (p.id_jugador = j.id)
	LEFT JOIN futbol_tipo_goles t ON (t.id = g.id_tipo_goles)
WHERE id_partido = $id_partido 
	AND ( p.id_clubes = $row[id_primer_club]
	OR p.id_clubes = $row[id_segundo_club] )
ORDER BY g.minuto";
//echo "<pre>".$sql."</pre>";
$resultado = mysql_query($sql);
	if(mysql_num_rows($resultado)!=0){ 
		while($fila = mysql_fetch_array($resultado)){ 
		$m = $fila["id_clubes"]; 
		?>	
	<TR> 
	  <TD class="<? echo $estilo_club[$m] ?>"><? echo $fila["numero"] . ") " . $fila["apellido"] . " " . $fila["nombre"] ?></TD>
	  <TD class="<? echo $estilo_club[$m] ?>"><? echo $fila["tipo"] ?></TD>
	  <TD class="<? echo $estilo_club[$m] ?>" align="center"><? echo $fila["minuto"] ?></TD>
	  <TD class="<? echo $estilo_club[$m] ?>"><INPUT name="accion" type="submit" class="bot" id="accion" onClick="javascript:document.all.id_registro.value=<? echo $fila["id"]?>;document.all.id_registro_club.value='<?
	if( $fila["id_tipo"] != "5"){
		if( $fila["id_clubes"] == $row["id_primer_club"] ){echo "primer";}else{echo "segundo";} 
	}else{
		if( $fila["id_clubes"] != $row["id_primer_club"] ){echo "primer";}else{echo "segundo";} 	
	}
		?>'" value="Borrar Goleador">
		</TD>
	</TR>
	<? } } ?> 
	<TR>
	  <TD class="Celeste"> 
		<? desplegar_jugadores("goleador_primer", $row["id_torneo"], $row["id_primer_club"]) ?><BR>
		<? desplegar_jugadores("goleador_segundo", $row["id_torneo"], $row["id_segundo_club"]) ?>
	  </TD>
	  <TD class="Blanco"><SELECT name="tipo_gol" id="tipo_gol">
		  <? $result_goles = mysql_query("SELECT * FROM futbol_tipo_goles");
	  while ($row_goles = mysql_fetch_array($result_goles)) {?>
		  <OPTION value="<? echo $row_goles["id"] ?>"><? echo $row_goles["tipo"] ?></OPTION>
		  <? } ?>
		</SELECT></TD>
	  <TD align="center"><INPUT name="gol_minuto" type="text" id="gol_minuto" size="6" maxlength="3"></TD>
	  <td>&nbsp;</td>
	</TR>
	<TR align="center"> 
	  <TD colspan="4" class="Celeste"><INPUT name="accion" type="submit" class="bot" id="accion" value="Agregar Goleador"></TD>
	</TR>
  </TABLE>
  <TABLE width="100%" border="0" align="center" cellpadding="0" cellspacing="1">
	<TR bgcolor="#D7E3DB"> 
	  <TD colspan="4" class="BackTitleFirst"><STRONG>Tarjetas</STRONG></TD>
	</TR>
	<TR> 
	  <TD width="300" class="BackRelaciones">Jugador</TD>
	  <TD width="50%" class="BackRelaciones">Tarjeta</TD>
	  <TD width="10" align="center" class="BackRelaciones">Minuto</TD>
	  <TD class="BackRelaciones">&nbsp;</TD>
	</TR>
	<? 
$resultado = mysql_query("SELECT t.id, t.minuto, j.apellido, j.nombre, 
j.numero, t.tarjeta, p.id_clubes
FROM futbol_tarjetas t
	LEFT JOIN futbol_jugadores j ON (j.id = t.id_jugador)
	LEFT JOIN futbol_planteles p ON (p.id_jugador = j.id)
WHERE id_partido = $id_partido 
	AND ( p.id_clubes = $row[id_primer_club]
	OR p.id_clubes = $row[id_segundo_club] )
ORDER BY t.minuto");
	if(mysql_num_rows($resultado)!=0){ 
		while($fila = mysql_fetch_array($resultado)){ 
		$m = $fila["id_clubes"]		
		?>
	<TR> 
	  <TD class="<? echo $estilo_club[$m] ?>"><? echo $fila["numero"] . ") " . $fila["apellido"] . " " . $fila["nombre"] ?></TD>
	  <TD class="<? echo $estilo_club[$m] ?>">
		<? if($fila["tarjeta"]==1){ echo "Roja";}else{ echo "Amarilla";} ?>
	  </TD>
	  <TD class="<? echo $estilo_club[$m] ?>" align="center"><? echo $fila["minuto"] ?></TD>
	  <TD class="<? echo $estilo_club[$m] ?>"><INPUT name="accion" type="submit" class="bot" id="accion" onClick="javascript:document.all.id_registro.value=<? echo $fila["id"]?>" value="Borrar Tarjeta"></TD>
	</TR>
	<? } } ?>
	<TR> 
	  <TD class="Celeste"> 
		<? desplegar_jugadores("tarjeta_jugador_primer", $row["id_torneo"], $row["id_primer_club"]) ?>
		<BR> 
		<? desplegar_jugadores("tarjeta_jugador_segundo", $row["id_torneo"], $row["id_segundo_club"]) ?>
	  </TD>
	  <TD class="Blanco"><SELECT name="tarjeta" id="tarjeta">
		  <OPTION value="0">Amarilla</OPTION>
		  <OPTION value="1">Roja</OPTION>
		</SELECT></TD>
	  <TD align="center"><INPUT name="tarjeta_minuto" type="text" id="tarjeta_minuto" size="6" maxlength="3"></TD>
	  <td>&nbsp;</td>
	</TR>
	<TR> 
	  <TD colspan="4" align="center" class="Celeste"><INPUT name="accion" type="submit" class="bot" id="accion" value="Agregar Tarjeta"></TD>
	</TR>
  </TABLE>
    <TABLE width="100%" border="0" align="center" cellpadding="0" cellspacing="1">
		<TR bgcolor="#D7E3DB"> 
			<TD colspan="4" class="BackTitleFirst"><STRONG>Acciones</STRONG></TD>
		</TR>
		<TR> 
			<TD width="300" class="BackRelaciones">Accion</TD>
			<TD width="50%" class="BackRelaciones">Descripcion</TD>
			<TD width="10" align="center" class="BackRelaciones">Minuto</TD>
			<TD class="BackRelaciones">&nbsp;</TD>
		</TR>
		<? $resultado = mysql_query("SELECT *
			FROM futbol_acciones
	WHERE id_partido = $id_partido 
	ORDER BY tiempo, minuto");
	if(mysql_num_rows($resultado)!=0){ 
		while($fila = mysql_fetch_array($resultado)){ ?>
		<TR> 
			<TD class="Celeste"><? 
			switch ($fila["accion"]) {
				case "1": echo "Gol"; break;
				case "2": echo "Juez"; break;
				case "10": echo "Cambio"; break;
				case "3": echo "Tiro de Esquina"; break;
				case "4": echo "Tiro Libre"; break;
				case "5": echo "Penal"; break;
				case "6": echo "Tarjeta Roja"; break;
				case "7": echo "Tarjeta Amarilla"; break;
				case "8": echo "Doble Amarilla (expulsi&oacute;n)"; break;
				case "9": echo "Incidentes"; break;
			} 
			?></TD>
			<TD class="Blanco"> 
				<? echo $fila["descripcion"] ?>
			</TD>
			<TD align="center" class="Celeste"><? echo $fila["minuto"] ?> - <? 
			switch ($fila["tiempo"]){
				case "1": echo "1&deg;T"; break;
				case "2": echo "2&deg;T"; break;
				case "3": echo "ET"; break;
				case "4": echo "1&deg;S"; break;
				case "5": echo "2&deg;S"; break;

			} ?></TD>
			<TD class="Celeste">
				<INPUT name="accion" type="submit" class="bot" id="accion" onClick="javascript:document.all.id_registro.value=<? echo $fila["id"]?>" value="Borrar Acción">
			</TD>
		</TR>
		<? } } ?>
		<TR> 
			<TD class="Celeste">
				<SELECT name="accion_accion" id="accion_accion">
					<OPTION value="0"></OPTION>
					<OPTION value="1">Gol</OPTION>
					<OPTION value="2">Juez</OPTION>
					<OPTION value="10">Cambio</OPTION>
					<OPTION value="3">Tiro de Esquina</OPTION>
					<OPTION value="4">Tiro Libre</OPTION>
					<OPTION value="5">Penal</OPTION>
					<OPTION value="6">Tarjeta Roja</OPTION>
					<OPTION value="7">Tarjeta Amarilla</OPTION>
					<OPTION value="8">Doble Amarilla (expulsi&oacute;n)</OPTION>
					<OPTION value="9">Incidentes</OPTION>
				</SELECT>
			</TD>
			<TD class="Blanco"> 
				<TEXTAREA name="accion_descripcion" rows="2" style="width:100%"></TEXTAREA>
			</TD>
			<TD align="center" nowrap>
				<INPUT name="accion_minuto" type="text" id="accion_minuto" size="6" maxlength="3">
				<SELECT name="accion_tiempo">
					<OPTION value="1">1&deg;T</OPTION>
					<OPTION value="2">2&deg;T</OPTION>
					<OPTION value="3">ET</OPTION>
					<OPTION value="4">1&deg;S</OPTION>
					<OPTION value="5">2&deg;S</OPTION>
				</SELECT>
			</TD>
			<td>&nbsp;</td>
		</TR>
		<TR> 
			<TD colspan="4" align="center" class="Celeste">
				<INPUT name="accion" type="submit" class="bot" id="accion" value="Agregar Acción">
			</TD>
		</TR>
	</TABLE>
</form>
<?
}
?>
<!------------------------ FIN FICHA PARTIDO ------------------------->

