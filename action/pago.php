<?php
include"../config/config.php";

$valor=$_REQUEST['valor'];
$id=$_REQUEST['id'];

$cons="UPDATE cheques set pago=$valor, fecha_pago=CURDATE() where id=$id";
if($sql=mysqli_query($con,$cons))
{
	echo"Se ha guardado tu confirmacion";
}else{
	echo"Error".mysqli_error($con);
}
?>