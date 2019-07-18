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
<link href="css/style.css" rel="stylesheet" type="text/css">
</HEAD>
<body bgcolor="E2E5C3" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td valign="bottom" class="PopEncuestaTop"><img src="../img/pop_encuesta_solap.gif" width="81" height="29"></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="4" cellpadding="0">
  <tr> 
    <td><TABLE width="230" border="0" cellpadding="0" cellspacing="0">
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
        <tr> 
          <td class="TitleResultadosEnc"><? echo $row["pregunta"] ?></td>
        </tr>
        <TR> 
          <TD><? echo $row["respuesta"] ?></TD>
        </TR>
        <TR> 
          <TD> 
            <? 
	  if ($total_votos!=0){
	  	$ancho = 100 * $row["votos"] / $total_votos;	  	
	  }else{
	  	$ancho = 1;
	  }
	   ?>
            <TABLE width="190" border="0" cellpadding="0" cellspacing="0">
              <TR> 
                <TD width="152"> <table border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td><img src="../img/estatus_bar_l.gif" width="1" height="18" vspace="2"></td>
                      <td><img src="../img/estatus_bar.gif" width="<? echo round($ancho)*2 ?>" height="18" vspace="2"></td>
                      <td><img src="../img/estatus_bar_r.gif" width="1" height="18" vspace="2"></td>
                    </tr>
                  </table></TD>
                <? if (round($ancho)!=0){ ?>
                <TD nowrap>&nbsp;<b><? echo round($ancho) ?>%</b></TD>
                <? } ?>
              </TR>
            </TABLE></TD>
        </TR>
        <TR class="Blanco"> 
          <TD><img src="../img/pop_encuesta_hr.gif" width="230" height="2" vspace="4"></TD>
        </TR>
       
        <?
  	}
}
  ?>
 <TR class="Blanco">
          <TD align="right"><a href="javascript:window.close()"><img src="../img/bot_aceptar.gif" width="63" height="25" vspace="2" border="0"></a></TD>
        </TR>      </TABLE> </td>
  </tr>
</table>
</BODY>
</HTML>

