<? if(isset($id)){ ?>
<FORM name="relaciones" action="" method="post">
<? 
$accion ="";
include "abm_header.php"; 
?>
<INPUT type="hidden" name="tabla" value="<? echo $tabla ?>">
<INPUT type="hidden" name="id" value="<? echo $id ?>">
<TABLE width= "100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
<TR>
<? 
$nombre_tabla["rel_noticias"] = "noticias";
$nombre_tabla["rel_opiniones"] = "opiniones";
$nombre_tabla["rel_entrevistas"] = "entrevistas";
while (list ($rel, $tab) = each ($nombre_tabla)) {
$variable = "add_" . $tab;
if(isset($$variable) && $$variable != ""){
	$sql = "INSERT INTO $rel VALUES('', $id, " . $$variable . ")"; 
	if(!mysql_query($sql)){
		echo "No se agrego relacion con $tab";
	}
}
$variable = "del_" . $tab;
if(isset($$variable) && $$variable != ""){
	$sql = "DELETE FROM $rel WHERE id=" . key($$variable) ; 
	if(!mysql_query($sql) ){
		echo "No se borro relacion con $tab";
	}
}
?>
<TD align="center" valign="top">
<TABLE width="100%" border="0" cellpadding="0" cellspacing="0">
<TR><TD colspan="2">
 
<TABLE width="100%" border="0" cellpadding="0" cellspacing="0">
<TR>
<TD width="90%" class="BackRelaciones">
<!--
<INPUT name="add_<? echo $tab ?>" id="add_<? echo $tab ?>"  type="text" value="" style="display:none">
-->
<SELECT name="add_<? echo $tab ?>" id="add_<? echo $tab ?>" onChange="javascript:document.forms[0].submit();" style="width:100">
	<OPTION value="">&nbsp;</OPTION>
</SELECT>
<? #echo strtoupper($tab) ?></TD>
<TD width="10%" align="center" class="BackRelaciones"><INPUT name="seleccionar" type="button" class="bot" id="seleccionar" onClick="javascript:abrirVentana('ow_frame.php?tabla=<? echo $tab ?>&include=vertabla&saltoPagina=uno&back_campo=add_<? echo $tab ?>', 'seleccionar', 600, 400);" value="Seleccionar"></TD>
</TR>
<TR>
<TD colspan="2"><INPUT type="submit" value="Relacionar <? echo $tab ?>" class="bot" style="width:100%"></TD>
</TR>
</TABLE>
</TD></TR>
<? 
if ($tab=="noticias") {
	$sql = "
	SELECT n.*, r.id AS id_rel 
	FROM rel_noticias r, noticias n
	WHERE
	(
		n.id = r.id_noticia AND
		r.id_noticias = ".$id."
	) OR (
		n.id = r.id_noticias AND
		r.id_noticia = ".$id."
	)
	";
}else{
	$sql = "SELECT $tab.*, $rel.id AS id_rel 
	FROM $rel 
	LEFT JOIN $tab ON($tab.id=$rel.id_$tab)
	WHERE id_noticia=$id";
}
#echo "<pre>".$sql."</pre>";
#exit;
$result = mysql_query($sql);
if(mysql_num_rows($result)!=0){
	while($row=mysql_fetch_array($result)){
?>
<TR>
<TD width="100%" class="Blanco" style="border-bottom: 1px #7B92AD solid; border-left: 1px #7B92AD solid"><? echo $row[1] ?></TD>
<TD class="Blanco" style="border-bottom: 1px #7B92AD solid; border-left: 1px #7B92AD solid"><INPUT name="del_<? echo $tab ?>[<? echo $row['id_rel'] ?>]" type="submit" class="bot" value="Borrar"></TD>
</TR>
<? 	} 
} ## fin del if
?>
</TABLE>
</TD>
<?
} ## fin del while
?>
</TR>
</TABLE>
</FORM>
<? }else{ 
echo "No esta seleccionado el registro en relación";
}
?>

