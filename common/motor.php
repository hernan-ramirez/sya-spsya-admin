<?
include $path . "common/conexion.php"; 
//############## SESION DEL USUARIO #############
if ( isset($login["mail"])){
	if ( strlen($login["mail"])!=0 && strlen($login["clave"])!=0  ){
		$result = mysql_query("SELECT * FROM suscriptos WHERE mail='" . $login["mail"] . "' AND clave='" . $login["clave"] . "'");
		if (mysql_num_rows($result)!=0){
			$row = mysql_fetch_array($result);
			$suscripto = $row["nombre"] . " " . $row["apellido"];
			$suscripto_id = $row["id"];
			setcookie("suscripto", $suscripto);
			setcookie("suscripto_id", $row["id"]);
		}
	}
}
if(isset($logoff)){
	setcookie("suscripto", "");
	unset($suscripto);
	setcookie("suscripto_id", "");
	unset($suscripto_id);
}
//##############  #############
?>

