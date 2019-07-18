<? 
############# QUERY #########
if($accion != ""){
	if ($accion == "modificar" || $accion == "borrar"){ $strQuery = "SELECT * FROM " . $tabla . " WHERE id=" . $id;}
	if ($accion == "agregar"){ $strQuery = "SELECT * FROM " . $tabla . " LIMIT 1";}
	$query = mysql_query($strQuery);
	$cantidad_campos = mysql_num_fields($query);
	$row = mysql_fetch_array($query);
	$mensaje = "";
}
################### FORMACION DE QUERYSTRING #####################
if(isset($ejecutar) && is_array(${"var_$accion"})){
	$ejecutar_query = true;
	$var = "var_" . $accion;
	$QueryExec_A1 = "INSERT INTO " . $tabla . " ("; 
	$QueryExec_A2 = ") VALUES (";
	$QueryExec_M = "UPDATE " . $tabla . " SET "; 
	for($Campo = 0; $Campo < $cantidad_campos; $Campo++){
		if(mysql_field_name($query,$Campo) != "id"){
			$QueryExec = "";
			$nom = mysql_field_name($query,$Campo);
			$tip = mysql_field_type($query,$Campo);
			$QueryExec_A1 .= "`" . $nom . "`";
			$QueryExec_M .= $nom . "=";
			if (isset(${$var}[$nom]) && substr($nom, 0, 8) != "archivo_"){
				if ($tip!="int"){ $QueryExec .= "'";}
				if ($tip=="int" && ${$var}[$nom]==""){ $QueryExec .= "''";}
				$QueryExec .= addslashes( ${$var}[$nom] );
				if ($tip!="int"){ $QueryExec .= "'";}
				if (substr($nom, 0, 5) == "clave"){ ####### si es clave
					$QueryExec = " PASSWORD(" . $QueryExec . ") ";
				}				
								
			}elseif(($tip=="date" || $tip=="datetime") && isset(${$var}[$nom.'_anio'])){
				$QueryExec .= "'" .${$var}[$nom.'_anio']. "-" . ${$var}[$nom.'_mes']. "-" . ${$var}[$nom.'_dia'] ;
				if ($tip=="datetime"){ $QueryExec .= " " . date("H:i:s");} 
				$QueryExec .= "'";
			###### AGREGAR ARCHIVO ########
			}elseif (substr($nom, 0, 8) == "archivo_" && $accion != "borrar"){
				if($HTTP_POST_FILES[$nom]['name']!=""){
					$nombre_carpeta = substr($nom, 8, strlen($nom));
					if(!isset($id)){
						$row_id = mysql_fetch_array(mysql_query("SHOW TABLE STATUS LIKE '" . $tabla . "'"));
						$id = $row_id["Auto_increment"];
					}
					$extencion = explode(".", $HTTP_POST_FILES[$nom]['name']);
					if(
					(strtolower($extencion[1]) == "jpg" || 
					 strtolower($extencion[1]) == "jpeg" || 
					 strtolower($extencion[1]) == "gif" || 
					 strtolower($extencion[1]) == "mov" || 
					 strtolower($extencion[1]) == "avi" || 
					 strtolower($extencion[1]) == "mpeg" || 
					 strtolower($extencion[1]) == "wav" || 
					 strtolower($extencion[1]) == "mp3" || 
					 strtolower($extencion[1]) == "rpm" ) &&
					 is_uploaded_file($HTTP_POST_FILES[$nom]['tmp_name'])
					){
						$destino = "clipart/". $nombre_carpeta . "/" . $id . "." . $extencion[1]; 
						if(!is_dir("clipart/". $nombre_carpeta . "/")){
							mkdir ("clipart/". $nombre_carpeta . "/"); 
						}
						
						move_uploaded_file( $HTTP_POST_FILES[$nom]['tmp_name'], $destino);
						$mensaje = "Archivo adjuntado";
						$QueryExec .= "'" . $id . "." . $extencion[1] . "'";
						chmod( $destino, 0777 ); 
					}else{
						$mensaje = "No se pudo subir " . $HTTP_POST_FILES[$nom]['tmp_name'];
						$QueryExec .= "''";
						$ejecutar_query = false;
		
					} ## fin del is_upload_file
				}else{
					$QueryExec .= "'" . ${$var}[$nom] . "'";
				}
			######  FIN AGREGAR ARCHIVO ########
			}else{
				$QueryExec .="''";
			}
		
			$QueryExec_A2 .= $QueryExec ; 
			$QueryExec_M .= $QueryExec ;
			if ($Campo != $cantidad_campos-1){$QueryExec_A1 .= ", ";$QueryExec_A2 .= ", ";$QueryExec_M .= ", ";	}			
		}
		}
		$QueryExec_A = $QueryExec_A1 . $QueryExec_A2 . ");";
#########  ABM
	switch($ejecutar){
		case "AGREGAR": 
			$ExecQuery = $QueryExec_A ; 
		break;
		
		case "MODIFICAR": 
			$ExecQuery = $QueryExec_M . " WHERE id=" . $id; 
		break;
		
		case "BORRAR": 
			$ExecQuery = "DELETE FROM " . $tabla . " WHERE id=" . $id; 
		break;
	}
	if($ejecutar_query){
		if (mysql_query($ExecQuery)){
			$id = mysql_insert_id();
			echo  $mensaje;
			#echo "<FONT size=2 color=ff9900 face=verdana><B>  Acción ($accion) Exitosa en la base de datos</B></FONT>";
		}else{
			#echo "<FONT size=2 color=red face=verdana><B>  ERROR en la Operación</B></FONT>";
			echo $ExecQuery;
		}
		if ($row_usuario['nombre']== "Hernán" && $row_usuario['apellido']=="Ramirez"){echo "<BR><PRE style='display:none'>" . $ExecQuery . "</PRE>";}
	}
	
	
	if( (isset($include) && $include=="abm")  ){ ##### && !isset($tiene_solapas)
		$include = "vertabla";
	}
/*
	if (!isset($tiene_solapas)){
		exit;
	}
*/	
}
?>