<?php
include "../config/config.php";
session_start();
$id=$_POST['id'];
$che=$_POST['che'];



if ($delete1=mysqli_query($con,"UPDATE desglose set si_aid='$che' WHERE id=$id "))
{
	echo("Se guardo la validacion");
}else
{
	echo "Error";
}
?>