<? include "abm_header.php"; ?>
<br>
<br>
<?
$sql = "SELECT n.*, f.archivo_imagen, p.pais, d.deporte FROM noticias n
LEFT JOIN fotos f ON (n.id_foto = f.id)
LEFT JOIN paises p ON (n.id_pais = p.id)
LEFT JOIN deportes d ON (n.id_deporte = d.id)
WHERE n.id= $id";
$result = mysql_query ($sql);
if(mysql_num_rows($result)!=0){
	$row = mysql_fetch_array($result);
?>
 
<TABLE width="468" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#FFFFFF">
  <TR> 
    <TD bgcolor="FDD74F"> <TABLE border="0" cellspacing="0" cellpadding="0">
        <TR> 
          			<TD><IMG src="../noticias/img/logo.gif" width="288" height="51" hspace="6" vspace="12"></TD>
          			<TD><IMG src="../noticias/img/pipe.gif" width="2" height="52"></TD>
          			<TD><IMG src="../noticias/img/spacer.gif" width="1" height="1"></TD>
          <TD><TABLE width="100%" border="0" cellspacing="0" cellpadding="0">
              <TR> 
                <TD><a href="onclick="javascript.print();"">Imprimir</a></TD>
              </TR>
              <TR> 
                <TD>Mandar via e mail</TD>
              </TR>
              <TR> 
                <TD><a href="javascript:window.close()">Cerrar</a></TD>
              </TR>
            </TABLE>
			</TD>
        </TR>
      </TABLE>
    </TD>
  </TR>
  <TR> 
    <TD bgcolor="#FFFFFF"><IMG src="img/spacer.gif" width="1" height="1"></TD>
  </TR>
  <TR>
    <TD class="NoticiaPopUp">
      <TABLE width="100%" border="0" cellspacing="2" cellpadding="2">
        <TR> 
          <TD class="small">
            <? echo $row["pais"] ?>
             | <b><? echo $row["deporte"] ?></b>
          </TD>
        </TR>
        <TR> 
          <TD class="TitlePpal"><? echo $row["titulo"] ?></TD>
        </TR>
		<TR>
          <TD class="Copete"><? echo $row["resumen"] ?></TD>
        </TR>
        <TR> 
          <TD valign="top"><TABLE width="228" border="0" align="left" cellpadding="0" cellspacing="0">
              <TR>
                <TD width="220"> 
                  <TABLE width="220" border="0" cellpadding="0" cellspacing="0">
                    <TR  > 
                      <TD><IMG src="../clipart/imagen/<? echo $row["archivo_imagen"] ?>" width="220" height="145"></TD>
                    </TR>
                    <TR> 
                      						<TD class="PopEpigrafe"><b>
												<? echo $row["epigrafe"] ?>
												</b></TD>
                    </TR>
                    <TR> 
                      						<TD>&nbsp;</TD>
                    </TR>
                  </TABLE>
                </TD>
                <TD width="8"><IMG src="img/spacer.gif" width="8" height="1"></TD>
              </TR>
            </TABLE>
            <? echo $row["cuerpo"] ?> </TD>
        </TR>
      </TABLE></TD>
  </TR>
</TABLE>
<?
} 
?>

