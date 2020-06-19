<?php
session_start();
include "../config/config.php";
$id=$_POST['id'];
$che=$_POST['che'];
$fecha_ok_sup="";

	$q_id=$_SESSION['user_id'];

$com="";
if($che=="1")
{
	$com=" ,com_sup='' ";
	$fecha_ok_sup=date('Y-m-d');
}
$cons="UPDATE desglose set ok_sup='$che',quien_sup='$q_id'$com,fecha_ok_sup='$fecha_ok_sup' WHERE id=$id and si_aid='0' ";
if ($delete1=mysqli_query($con,$cons))
{
	echo("Se guardo la validacion");
}else
{
	echo "Error";
}
?>