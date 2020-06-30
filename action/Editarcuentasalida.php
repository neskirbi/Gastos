<?php	
	session_start();
	/*Inicia validacion del lado del servidor*/
	include "../config/config.php";//Contiene funcion que conecta a la base de datos
	

	$id=$_REQUEST['id'];
	$cuentasalida=$_REQUEST['cuentasalida'];
	
	$update="UPDATE cheques set cuentasalida='".$cuentasalida."' where id='".$id."'  ";
	if($sql=mysqli_query($con,$update))
	{
		echo"1";
	}else{
		echo"0";
	}
			

	       


		
?>