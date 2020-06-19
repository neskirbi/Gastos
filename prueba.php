<?php

echo $numero = 1010799.85;
echo "<br>";
echo valorEnLetras($numero);


function valorEnLetras($x) 
{ 
	if ($x<0) { $signo = "MENOS ";} 
	else      { $signo = "";} 
	$x = abs ($x); 
	$C1 = $x; 

	$G6 = floor($x/(1000000));  // 7 y mas 

	$E7 = floor($x/(100000)); 
	$G7 = $E7-$G6*10;   // 6 

	$E8 = floor($x/1000); 
	$G8 = $E8-$E7*100;   // 5 y 4 

	$E9 = floor($x/100); 
	$G9 = $E9-$E8*10;  //  3 

	$E10 = floor($x); 
	$G10 = $E10-$E9*100;  // 2 y 1 


	$G11 = round(($x-$E10)*100,0);  // Decimales 
	////////////////////// 

	$H6 = unidades($G6); 

	if($G7==1 AND $G8==0) { $H7 = "CIEN "; } 
	else {    $H7 = decenas($G7); } 

	$H8 = unidades($G8); 

	if($G9==1 AND $G10==0) { $H9 = "CIEN "; } 
	else {    $H9 = decenas($G9); } 

	$H10 = unidades($G10); 

	if($G11 < 10) { $H11 = "0".$G11; } 
	else { $H11 = $G11; } 

	///////////////////////////// 
	    if($G6==0) { $I6=" "; } 
	elseif($G6==1) { $I6="MILLÓN "; } 
	         else { $I6="MILLONES "; } 
	          
	if ($G8==0 AND $G7==0) { $I8=" "; } 
	         else { $I8="MIL "; } 
	          
	$I10 = "PESOS "; 
	$I11 = "/100 M.N. "; 

	@$C3 = $signo.$H6.$I6.$H7.$I7.$H8.$I8.$H9.$I9.$H10.$I10.$H11.$I11;

	return $C3;

} 

function unidades($u) 
{ 
    if ($u==0)  {$ru = " ";} 
	elseif ($u==1)  {$ru = "UN ";} 
	elseif ($u==2)  {$ru = "DOS ";} 
	elseif ($u==3)  {$ru = "TRES ";} 
	elseif ($u==4)  {$ru = "CUATRO ";} 
	elseif ($u==5)  {$ru = "CINCO ";} 
	elseif ($u==6)  {$ru = "SEIS ";} 
	elseif ($u==7)  {$ru = "SIETE ";} 
	elseif ($u==8)  {$ru = "OCHO ";} 
	elseif ($u==9)  {$ru = "NUEVE ";} 
	elseif ($u==10) {$ru = "DIEZ ";} 

	elseif ($u==11) {$ru = "ONCE ";} 
	elseif ($u==12) {$ru = "DOCE ";} 
	elseif ($u==13) {$ru = "TRECE ";} 
	elseif ($u==14) {$ru = "CATORCE ";} 
	elseif ($u==15) {$ru = "QUINCE ";} 
	elseif ($u==16) {$ru = "DIECISEIS ";} 
	elseif ($u==17) {$ru = "DECISIETE ";} 
	elseif ($u==18) {$ru = "DIECIOCHO ";} 
	elseif ($u==19) {$ru = "DIECINUEVE ";} 
	elseif ($u==20) {$ru = "VEINTE ";} 

	elseif ($u==21) {$ru = "VEINTIUN ";} 
	elseif ($u==22) {$ru = "VEINTIDOS ";} 
	elseif ($u==23) {$ru = "VEINTITRES ";} 
	elseif ($u==24) {$ru = "VEINTICUATRO ";} 
	elseif ($u==25) {$ru = "VEINTICINCO ";} 
	elseif ($u==26) {$ru = "VEINTISEIS ";} 
	elseif ($u==27) {$ru = "VEINTISIENTE ";} 
	elseif ($u==28) {$ru = "VEINTIOCHO ";} 
	elseif ($u==29) {$ru = "VEINTINUEVE ";} 
	elseif ($u==30) {$ru = "TREINTA ";} 

	elseif ($u==31) {$ru = "TREINTA Y UN ";} 
	elseif ($u==32) {$ru = "TREINTA Y DOS ";} 
	elseif ($u==33) {$ru = "TREINTA Y TRES ";} 
	elseif ($u==34) {$ru = "TREINTA Y CUATRO ";} 
	elseif ($u==35) {$ru = "TREINTA Y CINCO ";} 
	elseif ($u==36) {$ru = "TREINTA Y SEIS ";} 
	elseif ($u==37) {$ru = "TREINTA Y SIETE ";} 
	elseif ($u==38) {$ru = "TREINTA Y OCHO ";} 
	elseif ($u==39) {$ru = "TREINTA Y NUEVE ";} 
	elseif ($u==40) {$ru = "CUARENTA ";} 

	elseif ($u==41) {$ru = "CUARENTA Y UN ";} 
	elseif ($u==42) {$ru = "CUARENTA Y DOS ";} 
	elseif ($u==43) {$ru = "CUARENTA Y TRES ";} 
	elseif ($u==44) {$ru = "CUARENTA Y CUATRO ";} 
	elseif ($u==45) {$ru = "CUARENTA Y CINCO ";} 
	elseif ($u==46) {$ru = "CUARENTA Y SEIS ";} 
	elseif ($u==47) {$ru = "CUARENTA Y SIETE ";} 
	elseif ($u==48) {$ru = "CUARENTA Y OCHO ";} 
	elseif ($u==49) {$ru = "CUARENTA Y NUEVE ";} 
	elseif ($u==50) {$ru = "CINCUENTA ";} 

	elseif ($u==51) {$ru = "CINCUENTA Y UN ";} 
	elseif ($u==52) {$ru = "CINCUENTA Y DOS ";} 
	elseif ($u==53) {$ru = "CINCUENTA Y TRES ";} 
	elseif ($u==54) {$ru = "CINCUENTA Y CUATRO ";} 
	elseif ($u==55) {$ru = "CINCUENTA Y CINCO ";} 
	elseif ($u==56) {$ru = "CINCUENTA Y SEIS ";} 
	elseif ($u==57) {$ru = "CINCUENTA Y SIETE ";} 
	elseif ($u==58) {$ru = "CINCUENTA Y OCHO ";} 
	elseif ($u==59) {$ru = "CINCUENTA Y NUEVE ";} 
	elseif ($u==60) {$ru = "SESENTA ";} 

	elseif ($u==61) {$ru = "SESENTA Y UN ";} 
	elseif ($u==62) {$ru = "SESENTA Y DOS ";} 
	elseif ($u==63) {$ru = "SESENTA Y TRES ";} 
	elseif ($u==64) {$ru = "SESENTA Y CUATRO ";} 
	elseif ($u==65) {$ru = "SESENTA Y CINCO ";} 
	elseif ($u==66) {$ru = "SESENTA Y SEIS ";} 
	elseif ($u==67) {$ru = "SESENTA Y SIETE ";} 
	elseif ($u==68) {$ru = "SESENTA Y OCHO ";} 
	elseif ($u==69) {$ru = "SESENTA Y NUEVE ";} 
	elseif ($u==70) {$ru = "SETENTA ";} 
 
 	elseif ($u==71) {$ru = "SETENTA Y UN ";} 
	elseif ($u==72) {$ru = "SETENTA Y DOS ";} 
	elseif ($u==73) {$ru = "SETENTA Y TRES ";} 
	elseif ($u==74) {$ru = "SETENTA Y CUATRO ";} 
	elseif ($u==75) {$ru = "SETENTA Y CINCO ";} 
	elseif ($u==76) {$ru = "SETENTA Y SEIS ";} 
	elseif ($u==77) {$ru = "SETENTA Y SIETE ";} 
	elseif ($u==78) {$ru = "SETENTA Y OCHO ";} 
	elseif ($u==79) {$ru = "SETENTA Y NUEVE ";} 
	elseif ($u==80) {$ru = "OCHENTA ";} 

	elseif ($u==81) {$ru = "OCHENTA Y UN ";} 
	elseif ($u==82) {$ru = "OCHENTA Y DOS ";} 
	elseif ($u==83) {$ru = "OCHENTA Y TRES ";} 
	elseif ($u==84) {$ru = "OCHENTA Y CUATRO ";} 
	elseif ($u==85) {$ru = "OCHENTA Y CINCO ";} 
	elseif ($u==86) {$ru = "OCHENTA Y SEIS ";} 
	elseif ($u==87) {$ru = "OCHENTA Y SIETE ";} 
	elseif ($u==88) {$ru = "OCHENTA Y OCHO ";} 
	elseif ($u==89) {$ru = "OCHENTA Y NUEVE ";} 
	elseif ($u==90) {$ru = "NOVENTA ";} 

	elseif ($u==91) {$ru = "NOVENTA Y UN ";} 
	elseif ($u==92) {$ru = "NOVENTA Y DOS ";} 
	elseif ($u==93) {$ru = "NOVENTA Y TRES ";} 
	elseif ($u==94) {$ru = "NOVENTA Y CUATRO ";} 
	elseif ($u==95) {$ru = "NOVENTA Y CINCO ";} 
	elseif ($u==96) {$ru = "NOVENTA Y SEIS ";} 
	elseif ($u==97) {$ru = "NOVENTA Y SIETE ";} 
	elseif ($u==98) {$ru = "NOVENTA Y OCHO ";} 
	else            {$ru = "NOVENTA Y NUEVE ";} 
	return $ru; //Retornar el resultado 
} 

function decenas($d) 
{ 
    if ($d==0)  {$rd = "";} 
	elseif ($d==1)  {$rd = "CIENTO ";} 
	elseif ($d==2)  {$rd = "DOSCIENTOS ";} 
	elseif ($d==3)  {$rd = "TRESCIENTOS ";} 
	elseif ($d==4)  {$rd = "CUATROCIENTOS ";} 
	elseif ($d==5)  {$rd = "QUINIENTOS ";} 
	elseif ($d==6)  {$rd = "SEISCIENTOS ";} 
	elseif ($d==7)  {$rd = "SETECIENTOS ";} 
	elseif ($d==8)  {$rd = "OCHOCIENTOS ";} 
	else            {$rd = "NOVECIENTOS ";} 
	return $rd;
} 
?>
