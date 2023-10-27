<?php


$op1 = $_GET['op1'];
$op2 = $_GET['op2'];
$op = $_GET['op'];


switch($op) {
	case "suma":
	$resultado = (int)$op1 + (int)$op2;
	break;
	
	case "resta":
	$resultado = (int)$op1 - (int)$op2;
	break;
	
	case "multiplicacion":
	$resultado = (int)$op1 * (int)$op2;
	break;
	
	case "division":
	$resultado = (int)$op1 / (int)$op2;
	break;
	default:
}

echo "El resultado es ".$resultado;

#$op1 = "3";
#$op2 = "5";

#$suma = (int)$op1 + (int)$op2;
#$multiplicacion = (int)$op1 * (int)$op2;


#echo $suma;
#echo $multiplicacion;

?>