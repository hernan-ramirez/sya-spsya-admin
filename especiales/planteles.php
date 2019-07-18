<? 
$path = "../";
include "../common/conexion.php" ?>
<HTML>
<HEAD>
<TITLE>Formación de Planteles<? echo str_repeat("&nbsp;",50) ?></TITLE>
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
	i = document.all.jugadores_todos;
	it = i.options[i.selectedIndex].text;
	iv = i.options[i.selectedIndex].value;
	f = parent.abm.formulario_planteles.elements['plantel[]'];
	var nuevo = parent.abm.document.createElement("OPTION");
	nuevo.text = it;
	nuevo.value = iv;
	nuevo.style.backgroundColor = "#FF0000";
	nuevo.style.color = "#FFFFFF";
	f.options.add(nuevo);
}
function obtener(){
	f = parent.abm.formulario_planteles.elements['plantel[]'];
	f.options[f.selectedIndex] = null;
}
function duplicar_torneo(){
	f = parent.abm.formulario_planteles;
	f.action = "?torneo_duplicar=" + document.all.torneo_duplicar.value;
	f.submit();	
}
function agregar_actualizar(){
	f = parent.abm.formulario_planteles;
	ff = f.elements['plantel[]'];
	for(e=0; e<ff.length; e++){
		ff.options[e].selected = true;
	}
	f.action = "?agregar_actualizar=si";
	f.submit();	
}
</SCRIPT>
</HEAD>

<BODY bgcolor="#D4D0c8" style="border:0;margin:0;" scroll="no">
<TABLE width="100%" height="100%" border="0" cellpadding="5" cellspacing="5">
  <TR> 
	<TD width="50%" height="20" nowrap>Todos los Jugadores</TD>
	<TD width="15">&nbsp;</TD>
	<TD width="50%" nowrap><STRONG>Seleccione</STRONG>:</TD>
  </TR>
  <TR> 
	<TD rowspan="2"><SELECT id="jugadores_todos" multiple style="width:100%;height:100%">
		<?
	$sql = "SELECT id, nombre, apellido FROM futbol_jugadores ORDER BY apellido";
	$result = mysql_query($sql);
	if(mysql_num_rows($result)!=0){
		$color = "FFFFFF";
		while($row=mysql_fetch_array($result)){
			?>
		<OPTION value="<? echo $row["id"] ?>" style="background-color:#<? echo $color ?>"><? echo $row["apellido"] . ", " . $row["nombre"] ?></OPTION>
		<?
			if($color=="FFFFFF"){ $color="EEEEEE";}else{ $color="FFFFFF";}
		}
	} 
	?>
	  </SELECT></TD>
	<TD><INPUT type="button" value="8" class="botones" onClick="pasar();"> <INPUT type="button" value="7" class="botones" onClick="obtener();"></TD>
	<TD height="100%"><IFRAME name="abm" src="planteles_abm.php" scrolling="auto" style="width:100%;height:100%"></IFRAME></TD>
  </TR>
  <TR> 
	<TD>&nbsp;</TD>
	<TD align="center" valign="top">
	<SPAN style="background-color:#FF0000; color:#FFFFFF">&nbsp;En Rojo&nbsp;</SPAN>&nbsp;Faltantes de Agregar o Actualizar<BR><BR>
	<FIELDSET style="width:100%;height:100%">
	<LEGEND>Acciones</LEGEND>
	  <TABLE border="0" align="center" cellpadding="2" cellspacing="2">
		<TR>
		  <TD nowrap><INPUT type="button" value="Agregar / Actualizar Este Plantel" style="background:url(../../img/seleccionar.gif) no-repeat 3 center" onClick="agregar_actualizar();">
		  </TD>
		</TR>
		<TR>
		  <TD nowrap>Duplicar a 
			<SELECT id="torneo_duplicar">
			  <OPTION>Torneo..</OPTION>
			<?
			$sql = "SELECT * FROM futbol_torneos ORDER BY torneo";
			$result = mysql_query($sql);
			if(mysql_num_rows($result)!=0){
				while($row=mysql_fetch_array($result)){
				?>
				<OPTION value="<? echo $row["id"] ?>"><? echo $row["torneo"] ?></OPTION>
				<?
				}
			} 
			?>
			</SELECT>
			<INPUT type="button" value="Ok" style="width:55; background:url(../../img/seleccionar.gif) no-repeat 3 center" onClick="duplicar_torneo();"></TD>
		</TR>
		<TR>
		  <TD align="center"><INPUT type="button" value="Cancelar" style="width:90; background:url(../../img/cerrar.gif) no-repeat 3 center" onClick="javascript:window.close();"></TD>
		</TR>
	  </TABLE>
	  </FIELDSET>
	  </TD>
  </TR>
</TABLE>
</BODY>
</HTML>