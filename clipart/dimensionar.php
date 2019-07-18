<?
$imagen = $_GET["imagen"];
$ancho = $_GET["ancho"];
$alto = $_GET["alto"];
$calidad = $_GET["calidad"];	/* De 1 a 100  */

if (substr($imagen,-3)=="jpg"||substr($imagen,-3)=="JPG"||substr($imagen,-4)=="JPEG")
	$src_img = imagecreatefromjpeg($imagen);
elseif (substr($imagen,-3)=="png"||substr($imagen,-3)=="PNG")
	$src_img = imagecreatefromgif($imagen);
else
	header("Location: $imagen");

$ancho_original = imagesx($src_img);
$alto_original = imagesy($src_img);

if (!$alto)
	$alto = ($ancho / $ancho_original) * $alto_original;
	
if (!$ancho)
	$ancho = ($alto / $alto_original) * $ancho_original;
	
if (!$calidad)
	$calidad = 80;

/* ## Para GD 2.0.1 o mayor ## */

$dst_img = imagecreatetruecolor($ancho,$alto); 
imagecopyresampled($dst_img, $src_img, 0, 0, 0, 0, $ancho, $alto, $ancho_original, $alto_original); 


/* ## Para versiones anteriores a GD 2.0.1 ##
$dst_img = imagecreate($ancho,$alto); 
imagecopyresized($dst_img, $src_img, 0, 0, 0, 0, $ancho, $alto, $ancho_original, $alto_original);
 */



/*
#################################
Para la Marca de Agua SportsYA!!:
ImageTTFText ( int im, int size, int angle, int x, int y, int color, string fontfile, string text)
imagestring ( int im, int font, int x, int y, string s, int col)
*/
if (isset($marca_de_agua) && $marca_de_agua=="si"){
	$blanco = ImageColorAllocate($dst_img, 255,255,255);
	imagestringup ( $dst_img, 5, $ancho-20, $alto-10, "SportsYA!", $blanco);
}
#################################

 
header("Content-type: image/jpeg"); 
imagejpeg($dst_img,'', $calidad);

imagedestroy($src_img);
imagedestroy($dst_img);
?>