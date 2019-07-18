<?
$path = "../";
include "conexion.php";
if (isset($voto_encuesta)){
	$sql = "UPDATE encuestas_respuestas 
	SET votos = votos + 1 
	WHERE id = " . $voto_encuesta;
	mysql_query($sql);
}
?>
<HTML>
<HEAD>
<TITLE>Resultados de la Encuesta</TITLE>
<META http-equiv="" content="text/html; charset=iso-8859-1">
</HEAD>
<BODY>
<TABLE>	
  <? 
	$total_votos = 0;
	$result = mysql_query("SELECT votos FROM encuestas_respuestas WHERE id_preguntas = " . $id_pregunta);
	if (mysql_num_rows($result)!=0){
		while ($row = mysql_fetch_array($result)){
			$total_votos = $total_votos + $row[0];
		}
	}
	$result = mysql_query("SELECT * FROM encuestas_respuestas WHERE id_preguntas = " . $id_pregunta);
	if (mysql_num_rows($result)!=0){
		while ($row = mysql_fetch_array($result)){
	?>
  <TR class="Blanco"> 
	<TD><? echo $row["respuesta"] ?></TD>
	<TD><? echo $row["votos"] ?></TD>
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
  </TR>
  <?
  	}
}
  ?>
</TABLE>
</BODY>
</HTML>

