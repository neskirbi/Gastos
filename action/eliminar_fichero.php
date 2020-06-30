<?php
include "../config/config.php";
	$id=$_POST['id'];
	$campo=$_POST['campo'];
	 $sql="SELECT $campo from desglose where id='$id'";
	$sql=mysqli_query($con,$sql);
	$nombre=mysqli_fetch_array($sql);
	$consulta="UPDATE desglose set $campo='' where id='$id' ";
	if(mysqli_query($con,$consulta))
	{
		if(unlink('../comprobantes/' . $nombre[$campo]))
		{
			
				echo"!Se elimino el fichero¡";
		}else
		{
			echo"!Erroral eliminar el fichero¡";
		}
	}
	
?>