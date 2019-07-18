<?
//################# CONFIGURACION DE CONEXION ##############
$base = "sportsya"; 
$conexion = mysql_connect("localhost", "sportsya", "hio75bdf"); 
$db = mysql_select_db($base, $conexion);
//################# VARIABLES GLOBALES ##############
    if (!empty($_GET)) {
        extract($_GET);
    } else if (!empty($HTTP_GET_VARS)) {
        extract($HTTP_GET_VARS);
    } 
    if (!empty($_POST)) {
        extract($_POST);
    } else if (!empty($HTTP_POST_VARS)) {
        extract($HTTP_POST_VARS);
    } 
	
    if (!empty($_SERVER)) {
        extract($_SERVER);
    } else if (!empty($HTTP_SERVER_VARS)) {
        extract($HTTP_SERVER_VARS);
    } 
	
    if (!empty($_COOKIE)) {
        extract($_COOKIE);
    } else if (!empty($HTTP_COOKIE_VARS)) {
        extract($HTTP_COOKIE_VARS);
    } 
	
include $path."common/acceso.inc.php";
?>