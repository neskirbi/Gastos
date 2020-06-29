<?php	
	session_start();
	/*Inicia validacion del lado del servidor*/
	include "../config/config.php";//Contiene funcion que conecta a la base de datos
	

	$id_cheque=$_REQUEST['id_cheque'];
	$FolioSantander=$_REQUEST['FolioSantander'];
	
	$update="UPDATE cheques set FolioSantander='".$FolioSantander."' where id='".$id_cheque."'  ";
	if($sql=mysqli_query($con,$update))
	{
		echo"1";
	}else{
		echo"0";
	}
			

	       


		
?>