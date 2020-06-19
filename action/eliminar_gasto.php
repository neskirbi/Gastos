<?php
include "../config/config.php";
$id= $_POST['id'];

$consulta="SELECT * from desglose WHERE id='".$id."' " ;
$ok_val=mysqli_query($con,$consulta);
$r=mysqli_fetch_array($ok_val);
if($r['ok_val']=="0")
{
	$consulta="UPDATE cheques set  monto=monto-(SELECT amount+iva from desglose where id='$id') where id=(select id_cheque from desglose where id='$id') and t_cheque='3' ";
	if ($up=mysqli_query($con,$consulta))
	{
		echo"Ok ";
	}else
	{
		echo"Error ";
	}
	
	if ($delete1=mysqli_query($con,"DELETE from desglose  WHERE id='".$id."'"))
	{
		echo "Gasto eliminado";
	}else
	{
		echo"No se pudo eliminar el gasto";
	}
}else
{
	echo "No se puede eliminar gasto, ya se valido";
}

?>