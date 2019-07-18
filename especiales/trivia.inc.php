<? include "abm_header.php"; ?>
<SCRIPT language="JavaScript" type="text/javascript">
function abp(id){
	if (id!=""){
	abrirVentana('ow.php?accion=modificar&tabla=encuestas_preguntas&base=<? echo $base ?>&id='+id,'preguntas',500,300);
	}
}

function agregarVinculado(tabla){
	archivo = "ow.php?accion=agregar&tabla="+ tabla + "&base=<? echo $base ?>";
	nombre_ventana = "agregar_" + tabla[1];
	window.open(archivo, nombre_ventana, "WIDTH=500, HEIGHT=300, scrollbars, resizable, top=150, left=150");
}
</SCRIPT>
<form action="" method="post">
<TABLE width="100%" border="0" cellspacing="0" cellpadding="0" class="BackTitleFirst">
  <TR>
	  <TD>&nbsp;</TD>
  </TR>
</TABLE>
<BR>
<TABLE border="0" align="center" cellpadding="0" cellspacing="0">
  <TR> 
	<TD class="HeaderContenido" align="center">Preguntas de la trivia</TD>
  </TR>
  <TR> 
	<TD align="center"> <SELECT name="s_var_modificar[id_encuestas_preguntas]" size="10" id="preguntas" 
	  onCLick="abp(this.value);" style="width:400">
		<?
$result = mysql_query("SELECT * FROM encuestas_preguntas WHERE id_trivia = $id ORDER BY orden");
if(mysql_num_rows($result)!=0){
while($row=mysql_fetch_array($result)){
?>
		<OPTION value="<? echo $row["id"] ?>"><? echo $row["pregunta"] ?></OPTION>
		<?
}}
?>
	  </SELECT> </TD>
  </TR>
  <TR> 
	<TD align="center"><INPUT  class="bot" type="button" value="Agregar" style="width:100%"
	onClick="javascript:agregarVinculado('encuestas_preguntas')"></TD>
  </TR>
  <TR>
	<TD align="center"><INPUT  class="bot" type="submit" value="Refrescar" style="width:100%"></TD>
  </TR>
</TABLE>
  <BR>
  <? 
  $result_g = mysql_query("SELECT COUNT(1) FROM trivias_participantes WHERE ck_correcta=1");
  if(mysql_num_rows($result_g)!=0){$row_g = mysql_fetch_array($result_g);}
  $result_p = mysql_query("SELECT COUNT(1) FROM trivias_participantes WHERE ck_correcta=0");
  if(mysql_num_rows($result_p)!=0){$row_p = mysql_fetch_array($result_p);}
  ?>
  <TABLE width="50%" border="1" align="center" cellpadding="0" cellspacing="0">
	<TR>
	  <TD><A href="javascript:abrirVentana('especiales/trivia_ganadores?id_trivia=<? echo $id ?>','gan',350,350);">Ganadores</A></TD>
	  <TD>Perdedores</TD>
	</TR>
	<TR>
	  <TD><? echo $row_g[0] ?></TD>
	  <TD><? echo $row_p[0] ?></TD>
	</TR>
  </TABLE>
</form>