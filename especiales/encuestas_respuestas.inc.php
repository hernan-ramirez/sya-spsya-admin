<? include "abm_header.php"; 
if(isset($id_respuesta_correcta)){
	mysql_query("UPDATE encuestas_respuestas SET ck_correcta=NULL WHERE id_preguntas=$id");
	mysql_query("UPDATE encuestas_respuestas SET ck_correcta=1 WHERE id=$id_respuesta_correcta");
}
if(!isset($path)){$path = "";}
include $path."especiales/common.inc.php";
if(isset($Submit) && is_array($encuestas_respuestas)){
	ejecutar("encuestas_respuestas");
}
if(isset($del_id)){
	mysql_query("DELETE FROM encuestas_respuestas WHERE id=".$del_id);
}
?><BR> 
<link rel="stylesheet" href="../includes/estilos_admin.css" type="text/css">
<FORM name="enc" action="?<? echo $QUERY_STRING ?>" method="post">
	    <INPUT type="hidden" name="encuestas_respuestas[id]">
	    <INPUT type="hidden" name="encuestas_respuestas[id_preguntas]" value="<? echo $id ?>">
  <BR>
  <TABLE width="300" border="0" align="center" cellpadding="0" cellspacing="0">
    <TR> 
	  <TD width="230" class="HeaderContenido">Respuesta</TD>
	  <TD class="HeaderContenido">Orden</TD></TR>
  <TR> 
	<TD><INPUT type="text" name="encuestas_respuestas[respuesta]" style="width:100%"></TD>
	<TD><INPUT type="text" name="encuestas_respuestas[orden]" style="width:100%"></TD>
  </TR>
  <TR> 
	<TD colspan="2"><INPUT name="Submit" type="submit" id="agregar" value="Agregar Respuesta" style="width:100%" class="bot" ></TD>
  </TR>
</TABLE>
  <BR>
  <TABLE border="0" align="center" cellpadding="0" cellspacing="0" class="Celeste">
	<TR> 
	  <TD class="HeaderContenido">Modificar</TD>
	  <TD class="HeaderContenido">Respuesta</TD>
	  <TD class="HeaderContenido">Orden</TD>
	  <TD class="HeaderContenido">Votos</TD>
	  <TD class="HeaderContenido">C</TD>
	  <TD class="HeaderContenido" style="width:230">Porcentajes</TD>
	  <TD class="HeaderContenido">Borrar</TD>
	</TR>
	<? 
	$total_votos = 0;
	$result = mysql_query("SELECT votos FROM encuestas_respuestas WHERE id_preguntas = " . $id);
	if (mysql_num_rows($result)!=0){
		while ($row = mysql_fetch_array($result)){
			$total_votos = $total_votos + $row[0];
		}
	}
	$result = mysql_query("SELECT * FROM encuestas_respuestas WHERE id_preguntas = $id ORDER BY orden");
	if (mysql_num_rows($result)!=0){
		while ($row = mysql_fetch_array($result)){
	?>
	<TR class="Blanco"> 
	  <TD><INPUT type="button" value="Modificar"  class="bot" 
	  onClick="javascript:modificar('<? echo $row["id"] ?>','<? echo $row["id_preguntas"] ?>','<? echo $row["respuesta"] ?>','<? echo $row["orden"]?>');document.forms[0].Submit.value='Modificar';"></TD>
	  <TD><? echo $row["respuesta"] ?></TD>
	  <TD><? echo $row["orden"] ?></TD>
	  <TD><? echo $row["votos"] ?></TD>
	  <TD align="center"><INPUT type="checkbox"<? if($row["ck_correcta"]==1){ echo " checked";}?> onClick="javascript:window.location='?tabla=<? echo $tabla ?>&include=<? echo $include ?>&id=<? echo $id ?>&id_respuesta_correcta=<? echo $row["id"] ?>'"></TD>
	  <TD style="width:230"> 
		<? 
	  if ($total_votos!=0){
	  	$ancho = 100 * $row["votos"] / $total_votos;	  	
	  }else{
	  	$ancho = 1;
	  }
	   ?>
		<TABLE border="1" cellpadding="0" cellspacing="1">
		  <TR> 
			<TD width="30"><? echo round($ancho) ?>%</TD>
			<? if (round($ancho)!=0){ ?>
			<TD bgcolor="#336666" width="<? echo round($ancho)*2 ?>">&nbsp;</TD>
			<? } ?>
		  </TR>
		</TABLE></TD>
	  <TD><INPUT type="button" value="Borrar"  class="bot" onClick="javascript:borrar('<? echo $row["respuesta"] ?>','<? echo $row["id"] ?>')"></TD>
	</TR>
	<?
  	}
}
  ?>
  </TABLE>
</FORM>

