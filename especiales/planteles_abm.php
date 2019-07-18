<? 
$path = "../";
include "../common/conexion.php";
if(isset($torneo_duplicar)){ 
	$sql = "SELECT id_jugador FROM futbol_planteles WHERE id_clubes = $planteles[id_clubes] && id_torneo = $planteles[id_torneo]";
	$result = mysql_query($sql);
	if(mysql_num_rows($result)!=0){
		while($row=mysql_fetch_array($result)){
			$result_exist = mysql_query("SELECT id FROM futbol_planteles WHERE id_clubes = $planteles[id_clubes] && id_torneo = $torneo_duplicar && id_jugador = $row[0]");
			if(mysql_num_rows($result_exist)==0){
				mysql_query("INSERT INTO futbol_planteles (id_clubes,id_jugador,id_torneo)VALUES($planteles[id_clubes],$row[0],$torneo_duplicar)");
			}
		}
	}
}

if(isset($agregar_actualizar)){
	for($i=0; $i < count($plantel); $i++){
		$sql .= $plantel[$i] . ",";
		$result_exist = mysql_query("SELECT id FROM futbol_planteles WHERE id_clubes = $planteles[id_clubes] && id_torneo = $planteles[id_torneo] && id_jugador = $plantel[$i]");
		if(mysql_num_rows($result_exist)==0){
			mysql_query("INSERT INTO futbol_planteles (id_clubes,id_jugador,id_torneo)VALUES($planteles[id_clubes],$plantel[$i],$planteles[id_torneo])");
		}
	}
	mysql_query("DELETE FROM futbol_planteles WHERE id_clubes = $planteles[id_clubes] && id_torneo = $planteles[id_torneo] && id_jugador not in(" . substr($sql,0,strlen($sql)-1) . ")");
}
?>
<HTML>
<HEAD>
<META http-equiv="" content="text/html; charset=iso-8859-1">
<STYLE>
td, select, input{
	font-family:arial;
	font-size:11px;
}
</STYLE>
</HEAD>

<BODY bgcolor="#D4D0c8" style="border:0;margin:0;" scroll="no">
<TABLE width="100%" height="100%" border="0" cellpadding="1" cellspacing="1">
<FORM action="planteles_abm.php" method="post" name="formulario_planteles" enctype="multipart/form-data">
<TR> 
	<TD width="50%" height="20"><SELECT name="planteles[id_clubes]" style="width:100%">
		<OPTION>Equipo..</OPTION>
		<?
			$sql = "SELECT * FROM futbol_clubes ORDER BY alias";
			$result = mysql_query($sql);
			if(mysql_num_rows($result)!=0){
				while($row=mysql_fetch_array($result)){
				?>
		<OPTION value="<? echo $row["id"] ?>"<? if($planteles["id_clubes"]==$row["id"]){echo " SELECTED";}?>><? echo $row["alias"] ?></OPTION>
		<?
				}
			} 
			?>
	  </SELECT></TD>
	<TD width="50%"><SELECT name="planteles[id_torneo]" style="width:100%">
		<OPTION>Torneo..</OPTION>
		<?
			$sql = "SELECT * FROM futbol_torneos ORDER BY torneo";
			$result = mysql_query($sql);
			if(mysql_num_rows($result)!=0){
				while($row=mysql_fetch_array($result)){
				?>
		<OPTION value="<? echo $row["id"] ?>"<? if($planteles["id_torneo"]==$row["id"]){echo " SELECTED";}?>><? echo $row["torneo"] ?></OPTION>
		<?
				}
			} 
			?>
	  </SELECT></TD>
	  <td><INPUT type="submit" name="refrescar_listado" value="Ref." style="width:65; background:url(../../img/refrescar.gif) no-repeat 3 center"></td>
  </TR>
  <TR> 
	<TD colspan="3"><SELECT name="plantel[]" multiple style="width:100%;height:100%">
		<?
if($planteles["id_clubes"]!="" && $planteles["id_torneo"]!=""){ 
	$sql = "SELECT j.id, j.nombre, j.apellido 
		FROM futbol_planteles p
			LEFT JOIN futbol_jugadores j ON(j.id = p.id_jugador)
		WHERE id_clubes = $planteles[id_clubes] && id_torneo = $planteles[id_torneo] 
		ORDER BY apellido";
	$result = mysql_query($sql);
	if(mysql_num_rows($result)!=0){
		$color = "FFFFFF";
		while($row=mysql_fetch_array($result)){
			?>
		<OPTION value="<? echo $row["id"] ?>" style="background-color:#<? echo $color ?>"><? echo $row["apellido"] . ", " . $row["nombre"] ?></OPTION>
		<?
			if($color=="FFFFFF"){ $color="DAE0E4";}else{ $color="FFFFFF";}
		}
	} 
}	?>
	  </SELECT></TD>
  </TR>
</FORM>  
</TABLE>
</BODY>
</HTML>
