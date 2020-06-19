<?php
include "../config/config.php";
session_start();
error_reporting(E_ALL);
ini_set('display_errors', '1');

$id=$_REQUEST['id'];
$id_cheque=$_REQUEST['id_cheque'];
$opt=intval($_REQUEST['opt']);
$comen=$_REQUEST['comen'];
$fecha_ok_cli=date('Y-m-d');
$q_id=$_SESSION['user_id'];


if($opt==1)
{
	if ($consulta=mysqli_query($con,"UPDATE desglose set ok_cli='1',quien_cli='$q_id',com_cli='',fecha_ok_cli='$fecha_ok_cli' WHERE id=$id and si_aid='0' "))
	{
		echo "Se guardo la validacion";
	}else
	{
		echo "Error";
	}
}else if($opt==2)
{
	if ($consulta=mysqli_query($con,"INSERT into papelera_desglose  (id_desglose,id_cheque,fecha,comentario) values($id,$id_cheque,'$fecha_ok_cli','$comen' ) "))
	{
		if ($consulta=mysqli_query($con,"UPDATE cheques set monto=monto-(select amount+iva as total from desglose where id =$id) where id=(select id_cheque from desglose where id=$id)  "))
		{
			if ($consulta=mysqli_query($con,"UPDATE desglose set id_cheque=0 WHERE id=$id  "))
			{
				echo("Se ha rechazado el gasto");
			}else
			{
				echo "Error";
			}
		}else
		{
			echo "Error";
		}
	}else
	{
		echo "Error";
	}
}




?>