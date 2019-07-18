<?
## FUNCIONES DE REPRESENTACION PARA LA ESTRUCTURA DE JERARQUIAS EN CASCADA
function estructura(){
	global $id_estructura, $espacios,$row ;
	if (!isset($id_estructura)){ $sql = "isNull(id_estructura)";}else{$sql = "id_estructura=" . $id_estructura;}
	$sql = "SELECT * FROM estructura WHERE ". $sql . " ORDER BY orden";
	$result = mysql_query($sql);	
	if($nf=mysql_num_rows($result)!=0){
		$espacios = $espacios + 6;
		while($row=mysql_fetch_array($result)){ 
			$id_estructura = $row["id"];
			impresion();
			estructura(); 
		}
		$espacios = $espacios - 6;
	}
}
function ubicacion(){
	global $id_estructura, $ubicacion;
	$sql = "SELECT * FROM estructura WHERE id = " . $id_estructura;
	$result = mysql_query($sql);
	if(mysql_num_rows($result)!=0){
		$row=mysql_fetch_array($result); 		
		$id_estructura = $row["id_estructura"];
		$ubicacion["path"] =  $row["nombre"] . " / " . $ubicacion["path"] ;
		$ubicacion["raiz"] = $row["id"];
		if (isset($id_estructura)){
			ubicacion(); 
		}
	}
}
?>

