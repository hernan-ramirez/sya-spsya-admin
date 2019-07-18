<? 
$path = "../";
include $path . "common/conexion.php" ;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML>
<HEAD>
<TITLE>Reportes de Admin SportsYA!</TITLE>
<META http-equiv="" content="text/html; charset=iso-8859-1">
<STYLE>
td, select, input{
	font-family:arial;
	font-size:11px;
}
.botones {
	font-family: Webdings;
	font-size: 13px;
	cursor: hand;
}
</STYLE>
</HEAD>

<BODY bgcolor="#D4D0c8" style="border:0;margin:0;">
<TABLE width="100%" height="100%" border="0" cellpadding="2" cellspacing="2">
  <TR>
    <TD height="50" valign="top"><FORM name="fil" method="post" action="">
	<FIELDSET><LEGEND>Filtrar por</LEGEND>
        <TABLE width="100%" border="0" cellspacing="2" cellpadding="2">
          <TR> 
            <TD width="50%">Dia 
              <? function armar_fecha($campo){
			  	global ${$campo."_dia"}, ${$campo."_mes"}, ${$campo."_anio"};
			  ?>
              <SELECT name="<? echo $campo ?>_dia">
                <OPTION value="">&nbsp;</OPTION>
                <? for($d=1;$d<=31;$d++){ ?>
                <OPTION value="<? echo substr("00".$d,-2) ?>"<? if($d==${$campo."_dia"}){echo " selected";}?>><? echo $d ?></OPTION>
                <? } ?>
              </SELECT> <SELECT name="<? echo $campo ?>_mes">
                <OPTION value="">&nbsp;</OPTION>
                <? for($m=1;$m<=12;$m++){ ?>
                <OPTION value="<? echo substr("00".$m,-2) ?>"<? if ($m==${$campo."_mes"}){echo " selected";}?>><? echo $m ?></OPTION>
                <? } ?>
              </SELECT> <SELECT name="<? echo $campo ?>_anio">
                <OPTION value="">&nbsp;</OPTION>
                <? for($a=date("Y")-3;$a<=date("Y")+3;$a++){ ?>
                <OPTION value="<? echo $a ?>"<? if ($a==${$campo."_anio"}){echo " selected";}?>><? echo $a ?></OPTION>
                <? } ?>
              </SELECT> 
              <? } 
				armar_fecha("fecha");
				?>
            </TD>
          </TR>
          <TR> 
            <TD>Per&iacute;odo Desde 
              <? armar_fecha("desde"); ?>
              Hasta 
              <? armar_fecha("hasta"); ?>
            </TD>
          </TR>
          <TR> 
            <TD>Usuario 
              <SELECT name="usuario">
                <OPTION value="">&nbsp;</OPTION>
                <?
######################### DESPLIEGO USUARIOS ########################
			$sql = "SELECT * FROM usuarios ORDER BY apellido";
			$result = mysql_query($sql);
			if(mysql_num_rows($result)!=0){
				while($row=mysql_fetch_array($result)){
				?>
                <OPTION value="<? echo $row["id"] ?>"<? if($usuario==$row["id"]){echo " SELECTED";}?>><? echo $row["apellido"] ?>&nbsp;<? echo $row["nombre"] ?></OPTION>
                <?
				}
			} 
			?>
              </SELECT> &Oacute; Pais 
              <SELECT name="pais">
                <OPTION value="">&nbsp;</OPTION>
                <?
######################### DESPLIEGO PAISES ########################
			$sql = "SELECT * FROM paises ORDER BY pais";
			$result = mysql_query($sql);
			if(mysql_num_rows($result)!=0){
				while($row=mysql_fetch_array($result)){
				?>
                <OPTION value="<? echo $row["id"] ?>"<? if($pais==$row["id"]){echo " SELECTED";}?>><? echo $row["pais"] ?></OPTION>
                <?
				}
			} 
			?>
              </SELECT></TD>
          </TR>
          <TR>
            <TD><INPUT name="filtrar" type="submit" id="filtrar" value="Filtrar"></TD>
          </TR>
        </TABLE></FIELDSET>
      </FORM></TD>
  </TR>
  <TR>
    <TD valign="top"><TABLE width="100%" border="0" cellpadding="1" cellspacing="1" bgcolor="#000000">
        <TR bgcolor="#CCCCCC">
          <TD>Usuario</TD>
          <TD>Noticias Totales</TD>
        </TR>
			<?
######################### DESPLIEGO TORNEOS ########################
		$sql = "
		SELECT n._id_usuario, u.apellido, u.nombre, p.pais, count(1) AS cantidad
		FROM noticias n
		LEFT JOIN usuarios u ON(u.id = n._id_usuario)
		LEFT JOIN paises p ON(p.id = u.id_pais)
		WHERE _id_usuario IS NOT NULL AND _id_usuario <> 0 
		";
		if (isset($fecha_dia) && $fecha_dia!=""){ $sql .= "
			AND TO_DAYS(n.fecha_creacion) = TO_DAYS('". $fecha_anio . "-" . $fecha_mes . "-". $fecha_dia . "')
		"; }
		if (isset($desde_dia) && $desde_dia!=""){ $sql .= "
			AND TO_DAYS(n.fecha_creacion) >= TO_DAYS('". $desde_anio . "-" . $desde_mes . "-". $desde_dia . "') 
			AND TO_DAYS(n.fecha_creacion) <= TO_DAYS('". $hasta_anio . "-" . $hasta_mes . "-". $hasta_dia . "') 
		"; }
		if (isset($usuario) && $usuario!=""){ $sql .= "
			AND u.id = ". $usuario ; 
		}
		if (isset($pais) && $pais!=""){ $sql .= "
			AND u.id_pais = ". $pais ; 
		}
  		$sql .= " 
		GROUP BY _id_usuario
		ORDER BY apellido
		";
		echo "<pre style='display:none'>" . $sql . "</pre>";
		$result = mysql_query($sql);
		if(mysql_num_rows($result)!=0){
			while($row=mysql_fetch_array($result)){
			?>
        <TR bgcolor="#FFFFFF">
          <TD><? echo $row["apellido"] ?>&nbsp;<? echo $row["nombre"] ?></TD>
          <TD><? echo $row["cantidad"] ?></TD>
        </TR>
			<?
			}
		} 
		?>
        <TR bgcolor="#CCCCCC">
          <TD>Pais</TD>
          <TD>&nbsp; </TD>
        </TR>
		<?
		$sql = str_replace("GROUP BY _id_usuario","GROUP BY pais",$sql);
		$result = mysql_query($sql);
		if(mysql_num_rows($result)!=0){
			while($row=mysql_fetch_array($result)){
			?>
        <TR bgcolor="#FFFFFF">
          <TD><? echo $row["pais"] ?></TD>
          <TD><? echo $row["cantidad"] ?></TD>
        </TR>
			<?
			}
		} 
		?>
      </TABLE></TD>
  </TR>
</TABLE>
</BODY>
</HTML>
