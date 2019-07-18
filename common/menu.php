<table width="165" border="0" cellspacing="0" cellpadding="0">
	<tr>
	    <td class="SpacerMenu"><img src="<? echo $path ?>img/spacer.gif" width="100%" height="1"></td>
	</tr><?
function impresion() {
	global $path, $row, $espacios;
	if($row["ck_activa"]==1){
	if($row["tipo"] == 3){ $estilo="SubMenu"; }else{ $estilo="Menu"; }
	if($row["tipo"] == 1){ ############### SOLAPA TITULO
		$estilo="MenuSecciones";
		?>
		<tr>
		<td class="MenuSecciones">
		<? ### if($espacios>0){  echo str_repeat ("&nbsp;", $espacios) ;}  ?>
	    	<? echo $row["nombre"] ?>
		</td>
		</tr>
	<? }else{ ############### SOLAPA NORMAL 
		if($row["link"]!="" && $row["tipo"] == 3){
			if( strpos($row["link"], "javascript" )===false){ 
				$href = $path . stripslashes($row["link"]) . "?id_estruc=".$row["id"]; 
			}else{
				$href = stripslashes($row["link"]);
			}
		}elseif($row["link"]!="" && ($row["tipo"] == 4 || $row["tipo"] == 5) ){
			$href = stripslashes($row["link"]);
		}else{
		  	$href = $path . "welcome/index.php?id_estruc=".$row["id"];
		}
		?>
		<tr onclick="<? if( strpos($row["link"], "javascript" )===false){ ?>javascript:top.location='<? echo $href ?>';<? }else{ echo $href; } ?>">
		<td class="<? echo $estilo ?>" onmouseover="this.className='<? echo $estilo ?>Over';" onmouseout="this.className='<? echo $estilo ?>Off';">
		<? ### if($espacios>0){  echo str_repeat ("&nbsp;", $espacios) ;}  ?>
    		<A href="<? echo $href ?>"><? echo $row["nombre"] ?></A>
		</td>
		</tr>
	<? } ?>
	<tr>
	    <td class="Spacer<? echo $estilo ?>"><img src="<? echo $path ?>img/spacer.gif" width="100%" height="1"></td>
	</tr>
	<?
	} ## del if ck_activa
} ## fin de la funcion
require_once $path."common/estructura.fnc.php";
$espacios = -6;
$id_estructura = $ubicacion["raiz"];
estructura();
?>
</table>
<BR>
