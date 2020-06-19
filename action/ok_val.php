<?php
session_start();
include "../config/config.php";
$id=$_POST['id'];
$che=$_POST['che'];
	$q_id=$_SESSION['user_id'];

$com="";
if($che=="1")
{
	$com=" ,com_val='' ";
}
$consulta="UPDATE desglose set ok_val='$che',quien_val='$q_id'$com WHERE id=$id ";
if ($delete1=mysqli_query($con,$consulta))
{
	echo("Se guardo la validacion");
}else
{
	echo "Error";
}
?>