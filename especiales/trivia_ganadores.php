<?
$path = "../";
include "../common/conexion.php" ?>
<HTML>
<HEAD>
<TITLE>Ganadores de la Trivia</TITLE>
<META http-equiv="" content="text/html; charset=iso-8859-1">
</HEAD>

<BODY>
<A href="javascript:window.print();">IMPRIMIR</A><BR>
<BR>
<?
$sql = "SELECT s.* 
FROM trivias_participantes tp
LEFT JOIN suscriptos s ON (s.id = tp.id_suscripto)
WHERE ck_correcta = 1 AND id_trivia = $id_trivia";
#echo $sql;
$result = mysql_query($sql);
if(mysql_num_rows($result)!=0){
while($row=mysql_fetch_array($result)){
?>
<? echo $row["nombre"] ?> <? echo $row["apellido"] ?> <? echo $row["email"] ?> 
<? echo $row["direccion"] ?><BR>
<?
}}
?>
</BODY>
</HTML>
