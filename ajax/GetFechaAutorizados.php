<?php

include"../config/config.php";

$sql="SELECT distinct(fechaautorizado) as fechaautorizado from cheques where fechaautorizado!='0000-00-00' order by fechaautorizado desc";
$rows = mysqli_query($con,$sql);
$html='<option value="0">-- Fecha --</option>';
while ($row=mysqli_fetch_array($rows)){
	$html.='<option value="'.$row['fechaautorizado'].'" >Autorizacion: '.$row['fechaautorizado'].'</option>';
}

echo $html;

?>

