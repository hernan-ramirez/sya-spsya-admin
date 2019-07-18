<?
$path = "../";
include $path."common/conexion.php"; 
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<TITLE> Verificador </TITLE>
<META NAME="Generator" CONTENT="EditPlus">
<LINK href="../includes/estilos_admin.css" rel="stylesheet" type="text/css">
<META http-equiv="" content="text/html; charset=iso-8859-1"></HEAD>

<BODY leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?
if(isset($id_estructura) && $id_estructura!=""){
$sql = "SELECT * 
FROM `secciones` 
WHERE `id_lista_tablas` = 40
ORDER BY orden";

$result = mysql_query($sql);
if (mysql_num_rows($result)!=0){
	while ($row = mysql_fetch_array($result)){
		?>
		
<table width="100%">
		
  <tr>
	<td class="HeaderContenido" colspan="2"><? echo $row["seccion"]; ?></td>
  </tr>
		
  <? for($i=1; $i<=$row["cantidad"]; $i++){ ?>
			
  <tr>
	<td bgcolor="#FFFFFF" align="center" width="12"><? echo $i ?></td>
	<? $sql = "SELECT n.titulo 
			FROM `publicaciones`  p
			LEFT JOIN noticias n ON(n.id = p.id_publicado)
			WHERE `id_lista_tablas` = 40 
			AND `id_estructura` = $id_estructura 
			AND `id_seccion` = $row[id] 
			AND `posicion` = $i ";
			$result_h = mysql_query($sql);
			if (mysql_num_rows($result_h)!=0){
				$row_h = mysql_fetch_array($result_h);
			?>
				
	<td bgcolor="#E9ECEF" width="100%"><? echo $row_h["titulo"] ?></td>
	<? }else{ ?>
				
	<td bgcolor="#FF0000"><FONT color="#FFFF99"><B>HUECO</B></FONT></td>
	<? } ?>
			</tr>
		
  <? } ?>
		
</table>
<BR>
		<?
	}
}
}else{ ## isset($id_estructura)
	echo "Debe seleccionar la sección a verificar";
}
?>
</BODY>
</HTML>