<?php

$edad = $_GET['edad'];


if($edad >= 0 && $edad < 4) {
	$categoria = "Infante";	
	echo $categoria;
}

elseif($edad >= 4 && $edad < 17) {
	$categoria = "Niño";	
	echo $categoria;
}

elseif($edad >= 18 && $edad < 65) {
	$categoria = "Adulto";	
	echo $categoria;

}

elseif($edad >= 65) {
	$categoria = "Señor";	
	echo $categoria;

}



?>