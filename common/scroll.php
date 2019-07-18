<APPLET CODEBASE="<? echo $path ?>java/home" CODE="aTicker.class" ARCHIVE="aTicker.jar" WIDTH=100% HEIGHT=16 >
                                <PARAM NAME="_script" VALUE="./mess.txt">
                                <PARAM NAME="file" VALUE="s">
                                <PARAM NAME="cSep" VALUE=";">
                                <PARAM NAME="speed" VALUE="2">
                                <PARAM NAME="delay" VALUE="40">
                                <PARAM NAME="local" VALUE="false">
                                <PARAM NAME="bgcolor" VALUE="10000000">
                                <PARAM NAME="Font1" VALUE="Arial, 12, 0, 16777215">
                                <PARAM NAME="Font2" VALUE="Arial, 12, 4, 16777215">
<?
$result = mysql_query("
SELECT DISTINCT(n.titulo), n.copete, p.alias, n.id
FROM publicaciones pu
	LEFT JOIN noticias n ON (pu.id_publicado = n.id)
	LEFT JOIN paises p ON (n.id_pais = p.id)
WHERE pu.id_lista_tablas = 40
ORDER BY RAND()
LIMIT 10
");
if (mysql_num_rows($result)!=0){
	$x=0;
	while($row = mysql_fetch_array($result)){
		?><PARAM NAME="s<? echo $x ?>" VALUE="<? 
		if($row["alias"]!=""){ echo "(".$row["alias"].") "; }
		echo $row["titulo"] ?>: <? echo $row["copete"] 
		?>; ../../welcome/popup.php?id_not=<? echo $row["id"] ?> ; _blank">
		<?
		$x++;
	}
}
?>
</APPLET>

