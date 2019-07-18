<? 
$sql_mam = "SELECT fp.*, fc.nombre as e1, fcc.nombre as e2
			FROM futbol_partidos fp
			LEFT JOIN futbol_clubes fc ON (fc.id = fp.id_primer_club)
			LEFT JOIN futbol_clubes fcc ON (fcc.id = fp.id_segundo_club)
			WHERE ck_mam = 1
			AND fecha_partido >= now()";
$result_mam = mysql_query($sql_mam);
if(mysql_num_rows($result_mam)!=0){
?>
<TABLE width="140" border="0" cellspacing="0" cellpadding="0">
    <TR>

	    <TD><IMG SRC="<? echo $path; ?>img/mam.gif" WIDTH="140" HEIGHT="20"></TD>
	</TR>
    <? while($row_mam=mysql_fetch_array($result_mam)){ 
	
		#if ($row_man["estado_partido"] != "En Vivo" && $row_man["ck_mam"]!=1){ $link = "ficha_partido.php"; } else { $link = "../mam.php";} 

	?>
    <TR>
		<TD><table width="140" border="0" cellspacing="0" cellpadding="0">

				<tr>
					<td class="BackEspecialesTerra"><A href="javascript:abrirVentana('<? echo $path ?>especiales/mam.php?id_partido=<? echo $row_mam["id"] ?>','<? echo $row_mam["id"] ?>',503,350);"><? echo $row_mam["fecha_partido"] ?> | <? echo $row_mam["hora_partido"] ?></A></td>
				</tr>
				<tr>
					<td class="Terra1"><? echo $row_mam["e1"] ?></td>
				</tr>
				<tr>
					<td class="Terra2"><? echo $row_mam["e2"] ?></td>
				</tr>
				<tr>
					<td width="1"><img src="<? echo $path; ?>img/spacer.gif" width="1" height="1"></td>
				</tr>
			</table>
		</TD>
	</TR>
    <? } ?>
</TABLE>
<table width="140" border="0" cellspacing="0" cellpadding="0">
<tr>
	<td align="right" bgcolor="#E5E5E5">&nbsp;</td>
</tr>
<tr>
	<td align="right" bgcolor="#E5E5E5"><img src="<? echo $path; ?>img/corner_r_b.gif" width="5" height="5"></td>
</tr>
</table>
<? } ?>
