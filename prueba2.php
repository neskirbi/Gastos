<?php
$fecha = date('Y');
for ($i=-2; $i <1000 ; $i++) { 
	$nuevafecha = strtotime ( '+'.$i.' year' , strtotime ( $fecha ) ) ;
	echo "<br>".$nuevafecha = date ( 'Y' , $nuevafecha );
}


?>