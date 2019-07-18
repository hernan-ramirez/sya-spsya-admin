<SCRIPT>
<!--
function modificar(){
	for(i=0; i<modificar.arguments.length; i++){
		document.forms[0].elements[i].value = modificar.arguments[i];
	}
}
function borrar(titulo,del_id){
	if(confirm("\n\n¿Esta seguro de borrar " + titulo + "?\n\n")){
		if (document.forms[0].action.indexOf("?")!=-1){
			union = "&";
		}else{
			union = "?";
		}
		document.forms[0].action = document.forms[0].action + union +"del_id=" + del_id;
		document.forms[0].submit();
	}
}
//-->
</SCRIPT>
<?
function subir_archivo($nom){
	global $tabla, $$tabla;
	$path_rel = "../";
	$nombre_carpeta = substr($nom, 8, strlen($nom));
	if(!isset(${$tabla}["id"])){
		$row_id = mysql_fetch_array(mysql_query("SHOW TABLE STATUS LIKE '" . $tabla . "'"));
		$id = $row_id["Auto_increment"];
	}
	$extencion = explode(".", $HTTP_POST_FILES[$nom]['name']);
	if(is_uploaded_file($HTTP_POST_FILES[$nom]['tmp_name'])){
		$destino = $path_rel."clipart/". $nombre_carpeta . "/" . $id . "." . $extencion[1]; 
		if(!is_dir($path_rel."clipart/". $nombre_carpeta . "/")){
			mkdir ($path_rel."clipart/". $nombre_carpeta . "/"); 
		}
		
		move_uploaded_file( $HTTP_POST_FILES[$nom]['tmp_name'], $destino);
		$mensaje = "Archivo adjuntado";
		$sql = $id . "." . $extencion[1] ;
	}
	return $sql;
}
function ejecutar($tabla){
	global $$tabla;
	$sqlINa = "INSERT INTO ".$tabla." (\n";
	$sqlINb = ")VALUES(\n";
	$sqlUP = "UPDATE ".$tabla." SET \n";
	if(is_array($$tabla)){
		while(list($campo,$valor) = each($$tabla)){
			if($campo!="id" && strstr($campo,"archivo_")==false){
			$sqlINa .= $campo.", \n";
			if($valor!=""){
				$sqlINb .= "'".$valor."', \n";
				$sqlUP .= $campo . "='" . $valor . "', \n";
			}else{
				$sqlINb .= "NULL, \n";
				$sqlUP .= $campo . "=NULL, \n";
			} ## del valor nulo
			} ## del id
			
			if(strstr($campo,"archivo_")!=false && isset($HTTP_POST_FILES[$campo]) && $HTTP_POST_FILES[$campo]['tmp_name']!=""){
				$sqlINa .= $nom.", \n";
				$nombre_archivo = subir_archivo($campo);
				$sqlINb .= "'" . $nombre_archivo. "', \n";
				$sqlUP .= $nom . "='" . $nombre_archivo . "', \n";
			}
			
	   }## del while	
	}
	$sqlIN = substr($sqlINa,0,strlen($sqlINa)-3) . substr($sqlINb,0,strlen($sqlINb)-3).") \n";
	$sqlUP = substr($sqlUP,0,strlen($sqlUP)-3) . " WHERE id=" . ${$tabla}["id"];
	
	if(${$tabla}["id"]!=""){
		//echo "<PRE>" . $sqlUP . "</PRE>";
		mysql_query($sqlUP);
	}else{
		//echo "<PRE>" . $sqlIN . "</PRE>";
		mysql_query($sqlIN);
		$insert_id = mysql_insert_id();
	}	
}
?>

