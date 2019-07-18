<?
$path = "../";
include "../common/conexion.php" ;
$path_de_relacion = "../";
####################### AGREGAR #########################
if(isset($agregar_actualizar)){
	for($i=0; $i < count($fechas); $i++){
		$pos = strpos($fechas[$i], "|"); 
		if ($pos != false) {
			$partes = explode("|", $fechas[$i]);
			/*
			$sql_fechas .= "'" . $partes[0] . "',";
			$sql_locales .= $partes[1] . ",";
			$sql_visitantes .= $partes[2] . ",";
			*/
			$result_exist = mysql_query("SELECT id FROM futbol_partidos WHERE fecha_partido = '$partes[0]' && id_primer_club = $partes[1] && id_segundo_club = $partes[2] && id_torneo = $id_torneo && numero_fecha = $fecha && grupo = '$partes[3]' && orden_llave = '$partes[4]'");
			if(mysql_num_rows($result_exist)==0){
				$sql_in = "
				INSERT INTO futbol_partidos 
				(fecha_partido,id_primer_club,id_segundo_club,id_torneo,numero_fecha,grupo,orden_llave)
				VALUES('$partes[0]',$partes[1],$partes[2],$id_torneo,$fecha,'$partes[3]','$partes[4]')
				";
				if(mysql_query($sql_in)){
					$sql_ids .= mysql_insert_id() . ",";
				}
			}
		}else{
			$sql_ids .= $fechas[$i] . ",";
		}
	}
	#echo $sql_fechas . "<BR>" . $sql_locales . "<BR>" .  $sql_visitantes . "<BR>";
#################### BORRAR
	mysql_query("
	DELETE FROM futbol_partidos 
	WHERE id_torneo = $id_torneo 
	&& numero_fecha = $fecha 
	&& id not in(" . substr($sql_ids,0,strlen($sql_ids)-1) . ")
	");
	/*
		&& id_primer_club not in(" . substr($sql_locales,0,strlen($sql_locales)-1) . ")
		&& id_segundo_club not in(" . substr($sql_visitantes,0,strlen($sql_visitantes)-1) . ")
		&& fecha_partido not in(" . substr($sql_fechas,0,strlen($sql_fechas)-1) . ")
	*/
}
################### AGREGAR CLUB
if(isset($agregar_club) && $agregar_club_nombre !=""){
	mysql_query("INSERT INTO futbol_clubes (nombre, alias)VALUES('$agregar_club_nombre','$agregar_club_nombre')");
}
?>
<HTML>
<HEAD>
<TITLE>Administrador de Fechas<? echo str_repeat("&nbsp;",50) ?></TITLE>
<META http-equiv="" content="text/html; charset=iso-8859-1">
<STYLE>
td, select, input{
	font-family:arial;
	font-size:11px;
}
.botones {
	font-family: Webdings;
	font-size: 13px;
	cursor: hand;
}
</STYLE>
<SCRIPT language="JavaScript">
function pasar(){
	i = document.all.local;
	it = i.options[i.selectedIndex].text;
	iv = i.options[i.selectedIndex].value;
	
	e = document.all.visitante;
	et = i.options[e.selectedIndex].text;
	ev = i.options[e.selectedIndex].value;
	if(document.all.dia.value!="" && document.all.mes.value!="" && document.all.anio.value!=""){
		fecha_format = document.all.dia.value + "/" + document.all.mes.value + "/" + document.all.anio.value;
		fecha = document.all.anio.value + "-" + document.all.mes.value + "-" + document.all.dia.value;
	}else{
		fecha_format = "Sin Fecha";
		fecha = "";
	}
	
	var nuevo = document.createElement("OPTION");
	textoop = fecha_format + ") " + it + " - " + et + " ";
	if(document.all.grupo.value!=""){ textoop += "[ Grupo "  + document.all.grupo.value + " ] "; }
	if(document.all.llave.value!=""){ textoop += "{ Llave " + document.all.llave.value + " } "; }
	nuevo.text = textoop;
	nuevo.value = fecha + "|" + iv + "|" + ev + "|" + document.all.grupo.value + "|" + document.all.llave.value;
	nuevo.style.backgroundColor = "#FF0000";
	nuevo.style.color = "#FFFFFF";
	
	f = formulario_fechas.elements['fechas[]'];
	f.options.add(nuevo);
}
function obtener(){
	f = formulario_fechas.elements['fechas[]'];
	f.options[f.selectedIndex] = null;
}
function sube(obj){
	obj.value = ++obj.value;
}
function baja(obj){
	if(obj.value>>1){
		obj.value = --obj.value;
	}
}
function agregar_actualizar(){
	f = document.formulario_fechas;
	ff = f.elements['fechas[]'];
	for(e=0; e<ff.length; e++){
		ff.options[e].selected = true;
	}
	f.action = "?agregar_actualizar=si";
	f.submit();	
}

</SCRIPT>
</HEAD>

<BODY bgcolor="#D4D0c8" style="border:0;margin:0;" scroll="no">
<FORM action="futbol_fechas.php" method="post" name="formulario_fechas" enctype="multipart/form-data">
<TABLE width="100%" height="100%" border="0" cellpadding="5" cellspacing="5">
  <TR> 
	<TD width="50%" height="20" nowrap><strong>Clubes</strong></TD>
	<TD width="15">&nbsp;</TD>
	<TD width="50%" nowrap><STRONG>Seleccione</STRONG>:</TD>
  </TR>
  <TR> 
	<TD rowspan="2">
<table width="100%" border="0" cellspacing="0" cellpadding="1" style="height:100%">
        <tr> 
          <td height="20">Local</td>
        </tr>
        <tr> 
          <td><select name="var_agregar[id_primer_club]" multiple id="local" style="width:100%;height:100%">
              <?
################################ DESPLIEGO EQUIPOS ###############################
	if($fecha == 1){
		$sql = "SELECT * FROM futbol_clubes ORDER BY alias";
	}else{
		$sql = "
		SELECT p.id_primer_club AS id, c.alias
		FROM futbol_partidos p
			 LEFT JOIN `futbol_clubes` c ON(c.id = p.id_primer_club)
		WHERE id_torneo=$id_torneo
		AND numero_fecha=1
			UNION
		SELECT id_segundo_club AS id, c.alias
		FROM futbol_partidos p
			 LEFT JOIN `futbol_clubes` c ON(c.id = p.id_segundo_club)
		WHERE id_torneo=$id_torneo
		AND numero_fecha=1
		ORDER BY alias
		";
	}
	
	$result = mysql_query($sql);
	if(mysql_num_rows($result)!=0){
		$color = "FFFFFF";
		while($row=mysql_fetch_array($result)){
			?>
              <option value="<? echo $row["id"] ?>" style="background-color:#<? echo $color ?>"><? echo $row["alias"] ?></option>
              <?
			if($color=="FFFFFF"){ $color="EEEEEE";}else{ $color="FFFFFF";}
		}
	} 
	?>
            </select></td>
        </tr>
        <tr> 
          <td height="20"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="40%">Visitante</td>
				<? if($fecha==1){ ?>
                  <td width="50%" align="center"><input type="text" name="agregar_club_nombre" style="width:100%"></td>
                <td><input type="Submit" name="agregar_club" value="Agregar Club"></td>
				<? } ?>
              </tr>
            </table>
          </td>
        </tr>
        <tr> 
          <td><select multiple id="visitante" style="width:100%;height:100%">
              <?
	$result = mysql_query($sql);
	if(mysql_num_rows($result)!=0){
		$color = "FFFFFF";
		while($row=mysql_fetch_array($result)){
			?>
              <option value="<? echo $row["id"] ?>" style="background-color:#<? echo $color ?>"><? echo $row["alias"] ?></option>
              <?
			if($color=="FFFFFF"){ $color="EEEEEE";}else{ $color="FFFFFF";}
		}
	} 
	?>
            </select></td>
        </tr>
        <tr>
          <td height="25" align="center">
<TABLE width="100%" border="0" cellspacing="0" cellpadding="0">
                <TR>
                  <TD nowrap>Fecha 
                    <SELECT id="dia">
                      <OPTION value="">&nbsp;</OPTION>
                      <? for($d=1;$d<=31;$d++){ ?>
                      <OPTION value="<? echo $d ?>"<? if($d==date("j")){echo " selected";}?>><? echo $d ?></OPTION>
                      <? } ?>
                    </SELECT>
                    <SELECT id="mes">
                      <OPTION value="">&nbsp;</OPTION>
                      <? for($m=1;$m<=12;$m++){ ?>
                      <OPTION value="<? echo $m ?>"<? if ($m==date("n")){echo " selected";}?>><? echo $m ?></OPTION>
                      <? } ?>
                    </SELECT>
                    <SELECT id="anio">
                      <OPTION value="">&nbsp;</OPTION>
                      <? for($a=date("Y")-3;$a<=date("Y")+3;$a++){ ?>
                      <OPTION value="<? echo $a ?>"<? if ($a==date("Y")){echo " selected";}?>><? echo $a ?></OPTION>
                      <? } ?>
                    </SELECT> </TD>
                  <TD align="center">Grupo
                    <INPUT type="text" id="grupo" style="width:30px"></TD>
                  <TD align="right">Llave
                    <INPUT type="text" id="llave" style="width:30px"></TD>
                </TR>
              </TABLE></td>
        </tr>
      </table>
      <br>
      <br>
      <br>
    </TD>
	<TD><INPUT type="button" value="8" class="botones" onClick="pasar();"> <INPUT type="button" value="7" class="botones" onClick="obtener();"></TD>
	<TD height="100%"><TABLE width="100%" height="100%" border="0" cellpadding="1" cellspacing="1">
          <TR> 
            <TD width="50%" height="20"><SELECT name="id_torneo" style="width:100%">
                <OPTION>Torneo..</OPTION>
                <?
######################### DESPLIEGO TORNEOS ########################
			$sql = "SELECT * FROM futbol_torneos ORDER BY torneo";
			$result = mysql_query($sql);
			if(mysql_num_rows($result)!=0){
				while($row=mysql_fetch_array($result)){
				?>
                <OPTION value="<? echo $row["id"] ?>"<? if($id_torneo==$row["id"]){echo " SELECTED";}?>><? echo $row["torneo"] ?></OPTION>
                <?
				}
			} 
			?>
              </SELECT></TD>
            <TD width="50%" nowrap>Fecha 
              <INPUT name="button" type="button" class="botones" onClick="sube(document.all.fecha);" value="5" style="height:20px">
              <input name="fecha" type="text" id="fecha" style="width:20px" value="<? if(isset($fecha)){ echo $fecha; }else{ echo "1";}?>">
              <INPUT name="button2" type="button" class="botones" onClick="baja(document.all.fecha);" value="6" style="height:20px">
              </TD>
            <td><INPUT type="submit" name="refrescar_listado" value="Ref." style="width:65; background:url(../../img/refrescar.gif) no-repeat 3 center"></td>
          </TR>
          <TR> 
            <TD colspan="3"><SELECT name="fechas[]" multiple style="width:100%;height:100%">
                <?
###################### DESPLIEGO LOS PARTIDOS DE LA FECHA ###################
if($id_torneo!="" && $fecha!=""){ 
	$sql = "SELECT date_format(p.fecha_partido,'%e/%c/%Y') , c.alias, cc.alias,fecha_partido, p.id_primer_club, p.id_segundo_club, 
			p.id, p.grupo, p.orden_llave  
	FROM futbol_partidos p
		LEFT JOIN futbol_clubes c ON(c.id = p.id_primer_club)
		LEFT JOIN futbol_clubes cc ON(cc.id = p.id_segundo_club)
	WHERE id_torneo = $id_torneo
	AND numero_fecha = $fecha
	ORDER BY fecha_partido ASC";
	$result = mysql_query($sql);
	if(mysql_num_rows($result)!=0){
		$color = "FFFFFF";
		while($row=mysql_fetch_array($result)){
		# VALUE= echo $row[3] . "|" . $row[4] . "|" . $row[5] ;
			?>
                <OPTION value="<? echo $row["id"] ?>" style="background-color:#<? echo $color ?>">
				<? echo $row[0] . ") " . $row[1]. " - " . $row[2] ?>
				<? if($row["grupo"]!="0"){ echo " [ Grupo ".$row["grupo"]." ]"; } ?>
				<? if($row["orden_llave"]!="0"){ echo " { Llave ".$row["orden_llave"]." }"; } ?>
				</OPTION>
                <?
			if($color=="FFFFFF"){ $color="DAE0E4";}else{ $color="FFFFFF";}
		}
	} 
}	
#####################################
?>
              </SELECT>
            </TD>
          </TR>
      </TABLE>
      
    </TD>
  </TR>
  <TR> 
	<TD>&nbsp;</TD>
	<TD align="center" valign="bottom">
	<SPAN style="background-color:#FF0000; color:#FFFFFF">
      &nbsp;En Rojo&nbsp;</SPAN>&nbsp;Faltantes de Agregar o Actualizar<BR>
      <BR>
	<FIELDSET style="width:100%;height:100%">
	<LEGEND>Acciones</LEGEND>
	  <TABLE border="0" align="center" cellpadding="2" cellspacing="2">
        <TR> 
          <TD nowrap><INPUT type="button" value="Agregar / Actualizar Esta Fecha" style="background:url(../../img/seleccionar.gif) no-repeat 3 center" onClick="agregar_actualizar();"> 
          </TD>
        </TR>
        <TR> 
          <TD align="center"><INPUT type="button" value="Cancelar" style="width:90; background:url(../../img/cerrar.gif) no-repeat 3 center" onClick="javascript:window.close();"></TD>
        </TR>
      </TABLE>
	  </FIELDSET><BR>
	  </TD>
  </TR>
</TABLE>
</FORM>
</BODY>
</HTML>