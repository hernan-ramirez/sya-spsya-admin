<?
require_once $path."common/estructura.fnc.php";
$id_estructura = $id_estruc;
ubicacion();
#echo $ubicacion["path"] . "<BR>@". $ubicacion["raiz"] ;
unset($id_estructura);
?>
<table width="775" border="0" cellspacing="0" cellpadding="0">
    <tr background="<? echo $path ?>img/tags.gif" >
        <td width="165" class="Back1Gradee">&nbsp;</td>
				
		<td class="Back1GradeeSol">
			<? $result = mysql_query("SELECT * FROM estructura WHERE  isNull(id_estructura) ORDER BY orden");
if(mysql_num_rows($result)!=0){
	while($row=mysql_fetch_array($result)){ 
	$img_estado = "off";
	if($row['id']==$id_estruc || $row['id']==$ubicacion["raiz"]){ ##	
		$img_estado = "on"; 
	}
?>
			<table cellpadding="0" cellspacing="0" border="0" align="left">
				<tr>		
					<TD><IMG src="<? echo $path ?>img/solapa_1_<? echo $img_estado ?>.gif"></TD>
					<td class="BackSolapa<? echo $img_estado ?>" width="60" align="center" ><A href="<? echo $path ?>welcome/index.php?id_estruc=<? echo $row['id'] ?>">
						<? echo $row["nombre"] ?>
						</A></td>
					<TD><IMG src="<? echo $path ?>img/solapa_2_<? echo $img_estado ?>.gif"></TD>
					<TD><IMG src="img/spacer.gif" width="2"></TD>
				</tr>
			</table>
			<?
	}
}
?>
	</td>
		<td width="141" align="right" valign="top" class="Back1Gradee">&nbsp;</td>
	</tr>
</table>

