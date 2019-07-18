<center><font face="Tahoma" color="#FFFFFF" size="1"><?
$array_fecha = getdate();
switch ($array_fecha["wday"]){ // dia de la semana
	case 1: $dia = "Lunes"; break;
	case 2: $dia = "Martes"; break;
	case 3: $dia = "Miercoles"; break;
	case 4: $dia = "Jueves"; break;
	case 5: $dia = "Viernes"; break;
	case 6: $dia = "Sabado"; break;
	case 0: $dia = "Domingo"; break;
}
switch ($array_fecha["mon"]){ // mes del año
	case 1: $mes = "Enero"; break;
	case 2: $mes = "Febrero"; break;
	case 3: $mes = "Marzo"; break;
	case 4: $mes = "Abril"; break;
	case 5: $mes = "Mayo"; break;
	case 6: $mes = "Junio"; break;
	case 7: $mes = "Julio"; break;
	case 8: $mes = "Agosto"; break;
	case 9: $mes = "Septiembre"; break;
	case 10: $mes = "Octubre"; break;
	case 11: $mes = "Noviembre"; break;
	case 12: $mes = "Diciembre"; break;
}
echo $dia . 
" " . $array_fecha["mday"] . 
" de " . $mes . 
" de " . $array_fecha["year"] ;
?></font></center>

