<?php
include "../config/config.php";
$id=$_POST['id'];
$consulta="UPDATE cheques set status=1 where id='$id' ";

if($sql=mysqli_query($con,$consulta))
{
	echo "Se ha Solicitado el reembolso.";
	
}else
{
	echo"Error al solicitar el reembolso.";
}
?>