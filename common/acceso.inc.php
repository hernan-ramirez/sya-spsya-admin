<? 
session_start(); 
 if (!isset($_SERVER['PHP_AUTH_USER'])) { 
   header('WWW-Authenticate: Basic realm="SportsYA!.com AREA SEGURA"'); 
   header('HTTP/1.0 401 Unauthorized'); 
	echo "Ingreso mal alguno de los datos, intente nuevamente<BR>";
   exit; 
 } else if(!isset($_SESSION['id_usuario'])){ 
	$sql = "SELECT * FROM usuarios WHERE usuario = '" . $_SERVER['PHP_AUTH_USER'] . "' AND clave = PASSWORD('" . $_SERVER['PHP_AUTH_PW'] . "');";
	$result = mysql_query($sql);
	if (mysql_num_rows($result)!=0){ 
		$row_usuario = mysql_fetch_array($result);
		$_SESSION['id_usuario'] = $row_usuario['id'];
	} else {
	   header('WWW-Authenticate: Basic realm="SportsYA!.com AREA SEGURA !!Si no está seguro de su clave y contraseña!! !!NO INSISTA!!"'); 
	   header('HTTP/1.0 401 Unauthorized'); 
   		echo 'Ud no esta autorizado para ver esta sección'; 
   exit; 
	}
 }
if(isset($_SESSION['id_usuario'])){
	$id_usuario = $_SESSION['id_usuario'];
} 
?>