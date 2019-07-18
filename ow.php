<?
$path_de_relacion = "";
include "common/conexion.php";
include $path_de_relacion . "includes/funciones.php";
?>

<HTML>
<HEAD>
<TITLE>AGREGAR EN <? echo strtoupper($tabla) ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</TITLE>
<META http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK href="<? echo $path_de_relacion ?>includes/estilos_admin.css" rel="stylesheet" type="text/css">
</HEAD>
<BODY leftmargin="1" topmargin="1" marginwidth="1" marginheight="1" <? if(isset($ejecutar)){ echo 'onLoad="volver_abm()"';} ?>>
<?
if(!isset($include)){ $include = "abm";}
include $path_de_relacion . $include . ".php"; 
if(isset($ejecutar) && $include==""){
	$result = mysql_query("SELECT * FROM " . $tabla. " ORDER BY id DESC LIMIT 1");
	$row = mysql_fetch_array($result); 
?>
<SCRIPT language="JavaScript">
<!-- Agrega el nuevo ingreso en el desplegable del abm inicial -- hjr
function volver_abm(){
	campo_base = "id_<? echo substr($tabla,0, strlen($tabla)-2) ?>";
	for (var u=0; u<opener.document.formulario_abm.length; u++){
		campo_form = opener.document.formulario_abm.elements[u].name;
		if(campo_form.indexOf(campo_base)!=-1){
			campo = opener.document.formulario_abm.elements[u];
			break;
		}
	}
	
	var newElem = opener.document.createElement("OPTION");
	newElem.text = "<? echo $row[1] ?>";
	newElem.value = "<? echo $row[0] ?>";
	campo.options.add(newElem);
	campo.options[campo.length-1].selected = true;
	campo.focus();
	window.close();
}
// -->
</SCRIPT>
<? } ?>
</BODY>
</HTML>