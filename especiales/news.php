<?
$path = "../";
include "../common/conexion.php";
#$path = "http://localhost/public/www.sportsya.com/";
$path = "http://www.sportsya.com/";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SportsYa Newsletter</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="<? echo $path ?>common/css/style.css" rel="stylesheet" type="text/css">
</head>

<body bgcolor="5A595D" text="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="BackHeaderTop"><img src="<? echo $path ?>img/pop_logo.gif" width="179" height="43"></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="PopPadding"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><font color="#FFFFFF"><B><? echo date("d-m-y")?></B></font></td>
        </tr>
        <tr>
          <td class="PopTitle">Newsletter</td>
        </tr>
      </table>
      <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
        <tr>
          <td width="6"><img src="<? echo $path ?>img/pop_corner_lt.gif" width="6" height="6"></td>
          <td width="100%"><img src="<? echo $path ?>img/spacer.gif" width="1" height="1"></td>
          <td width="6"><img src="<? echo $path ?>img/pop_corner_rt.gif" width="6" height="6"></td>
        </tr>
        <tr>
          <td><img src="<? echo $path ?>img/spacer.gif" width="1" height="1"></td>
          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td valign="top"> 

<!--#######################################-->
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
				
  <? for($i=1; $i<=$row["cantidad"]; $i++){ ?>
			
	<? $sql = "SELECT n.titulo, n.copete, pa.alias, de.deporte, f.archivo_imagen
			FROM `publicaciones`  p
				LEFT JOIN noticias n ON(n.id = p.id_publicado)
				LEFT JOIN paises pa ON(pa.id = n.id_pais)
				LEFT JOIN deportes de ON(de.id = n.id_deporte)
				LEFT JOIN fotos f ON(f.id = n.id_foto)
			WHERE `id_lista_tablas` = 40 
			AND `id_estructura` = $id_estructura 
			AND `id_seccion` = $row[id] 
			AND `posicion` = $i ";
			$result_h = mysql_query($sql);
			if (mysql_num_rows($result_h)!=0){
				$row_h = mysql_fetch_array($result_h);
	if($i==1){
	?>
	<tr> 
	<td class="Dashed" style="border-bottom:2px dashed gray"><img src="<? echo $path ?>img/spacer.gif"><? #echo $row["seccion"]; ?></td>
	</tr>
	<? } ?>
  <tr>
	<td width="100%">
					<table width="100%" border="0" cellspacing="0" cellpadding="2">
                    <tr bgcolor="#E9ECEF"> 
                      <td colspan="2" valign="middle" class="small"><? echo $row_h["alias"] ?> | <B><? echo $row_h["deporte"] ?></B> </td>
                    </tr>
					
                    <tr> 
 						<td rowspan="2" align="center" valign="top">
						<? if($row_h["archivo_imagen"]!=""){ ?>
						<IMG src="<? echo $path ?>clipart/dimensionar.php?imagen=imagen/<? echo $row_h["archivo_imagen"] ?>&ancho=80&marca_de_agua=si" border="1">
						<? }else{ ?>&nbsp;<? } ?></td>
                     <td width="100%" valign="top" bgcolor="#E9ECEF" class="TitleSec"><a href="<? echo $path ?>welcome/index.php?id_estruc=<? echo $id_estructura ?>"><? echo $row_h["titulo"] ?></a></td>
                    </tr>
					
                    <tr> 
                      <td valign="top" bgcolor="#E9ECEF"><? echo $row_h["copete"] ?></td>
                    </tr>
					
                    <tr> 
                      <td class="Dashed"><img src="<? echo $path ?>img/spacer.gif"></td>
                      <td class="Dashed"><img src="<? echo $path ?>img/spacer.gif"></td>
                    </tr>
					
                  </table>

	</td>
			</tr>
	<? } #del if
	 } #del for ?>
		
</table>
<BR>
		<?
	}
}
}else{ ## isset($id_estructura)
	echo "Falta la seccion a mostrar";
}
?>
<!--###################################-->
                  <div align="center"><a href="mailto:desuscribir@sportsya.com"><font face="Arial, Helvetica, sans-serif">Si no desea seguir recibiendo este newsletter, haga click aquí</font></a></div></td>
              </tr>
              <tr> 
                <td valign="top">&nbsp;</td>
              </tr>
            </table></td>
          <td><img src="<? echo $path ?>img/spacer.gif" width="1" height="1"></td>
        </tr>
        <tr>
          <td><img src="<? echo $path ?>img/pop_corner_lb.gif" width="6" height="6"></td>
          <td><img src="<? echo $path ?>img/spacer.gif" width="1" height="1"></td>
          <td><img src="<? echo $path ?>img/pop_corner_rb.gif" width="6" height="6"></td>
        </tr>
      </table>
      
    </td>
  </tr>
</table>
</body>
</html>