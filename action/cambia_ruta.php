<?php 
include"../config/config.php";
$rutas= $_REQUEST['rutas']; 
$id=$_REQUEST['id'];
$consulta="UPDATE user set rutas='$rutas' where id='$id' ";
if(mysqli_query($con,$consulta))
{
	echo "1";
}else
{
	echo "0";
}
?>