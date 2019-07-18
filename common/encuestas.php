<?
$sql = "
SELECT pu.posicion , pr.id, pr.pregunta FROM publicaciones pu LEFT JOIN encuestas_preguntas pr ON(pr.id = pu.id_publicado ) 
WHERE pu.id_lista_tablas = 47 /* tabla de encuestas */ AND pu.id_estructura = $id_estruc 
"; ########### poner la pregunta publicada
#echo $sql;
$result = mysql_query($sql,$conexion);
if (mysql_num_rows($result)!=0) {
?>
<table width="140" border="0" cellpadding="0" cellspacing="0">
<form name="encuestas" method="post" action="" target="encuestas">
  <tr> 
    <td><img src="<? echo $path ?>img/header_encuesta.gif" alt="Encuesta" width="140" height="24" hspace="0" vspace="0" border="0"></td>
  </tr>
<?
while($row = mysql_fetch_array($result)){
	$id_pregunta = $row["id"] ;
?> 
  <tr> 
    <td align="right" class="BodyEncuesta"><img src="<? echo $path ?>img/corner_top_encuestas.gif" width="5" height="4"></td>
  </tr>
  <tr> 
    <td align="right" class="BodyEncuesta"> <table width="135" border="0" cellpadding="0" cellspacing="3">
        
        <tr> 
          <td class="BodyEncuesta"><? echo $row["pregunta"] ?></td>
        </tr>
      </table>
      <table width="140" border="0" cellpadding="0" cellspacing="0">
        <? 
		$sql = "SELECT * FROM encuestas_respuestas WHERE id_preguntas = $id_pregunta";
		#echo $sql;
		$result_respuestas = mysql_query($sql,$conexion);
		if (mysql_num_rows($result_respuestas)!=0){
		while ($row_resp = mysql_fetch_array($result_respuestas)){
		?>
        <tr> 
          <td width="10"><input type="radio" name="voto_encuesta" value="<? echo $row_resp["id"] ?>"></td>
          <td width="130" class="EntrevistaOpcion"><? echo $row_resp["respuesta"] ?></td>
        </tr>
        <? }
		} ?>
      </table>
      <table border="0" align="center" cellpadding="0" cellspacing="0">
        <tr> 
          <td><A href="javascript:abrirVentana('','encuestas',256,320);document.encuestas.action='<? echo $path; ?>common/encuestas_resultados.php?id_pregunta=<? echo $id_pregunta ?>';document.encuestas.submit();"><img src="<? echo $path ?>img/bot_enc_resultados.gif" alt="Ver Resultados" width="70" height="25" hspace="3" vspace="8" border="0"></a></td>
          <td><A href="javascript:abrirVentana('','encuestas',256,320);document.encuestas.action='<? echo $path; ?>common/encuestas_resultados.php?id_pregunta=<? echo $id_pregunta ?>';document.encuestas.submit();">
		  <img src="<? echo $path ?>img/bot_enc_votar.gif" alt="Votar" width="51" height="25" hspace="3" vspace="8" border="0"></a></td>
        </tr>
      </table></td>
  </tr>
	<tr> 
    <td><img src="<? echo $path ?>img/end_encuesta.gif" width="140" height="6"></td>
  </tr>
<?
	}
?>  </form>
</table>
<?
}
?>

