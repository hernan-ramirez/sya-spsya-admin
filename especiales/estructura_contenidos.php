<?
$path = "../";
 include "../common/conexion.php"; ?>
<HTML>
<HEAD>
<TITLE>Contenido de la estructura</TITLE>
<META http-equiv="" content="text/html; charset=iso-8859-1">
<LINK href="../includes/estilos_admin.css" rel="stylesheet" type="text/css">
<SCRIPT>
function marcar(id){
	bot = eval("window.document.contenidos.bot_" + id );
	ck = eval("window.document.contenidos.ck_" + id );
	if(ck.checked){
		ck.checked = false;
		bot.style.backgroundImage = "none" ;
	}else{
		ck.checked = true;
		bot.style.backgroundImage = "url(../image/back_bot_neutro.gif)" ;
	}
}
</SCRIPT>
<META http-equiv="" content="text/html; charset=iso-8859-1"></HEAD>
<BODY leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<FORM name="contenidos" action="" method="post">
<INPUT type="hidden" name="id_estructura" value="<? echo $id ?>">
<TABLE width="100%" border="0" align="center" cellspacing="0">
    <TR class="HeaderContenido"> 
	<TD align="center">Contenidos de <? echo $nom_estructura ?></TD>
	</TR>	
<?
$result = mysql_query("SELECT * FROM usuarios_lista_tablas"); 
if (mysql_num_rows($result)!=0){
	while($row=mysql_fetch_array($result)){
	?>
    <TR class="Submenu"> 
	<TD><INPUT type="button" id="bot_<? echo $row["id"] ?>" value="<? echo $row["nombre"] ?>"  style="width:100%; background:none; border:none" onClick="javascript:marcar('<? echo $row["id"] ?>');">
	<INPUT type="checkbox" id="ck_<? echo $row["id"] ?>" name="id_contenido" value="<? echo $row["id"] ?>" style="display:none"></TD>
	</TR>	
	<?
	}
}
?>
</TABLE>
</FORM>
</BODY>
</HTML>

