<?php	
	session_start();
	/*Inicia validacion del lado del servidor*/
	include "../config/config.php";//Contiene funcion que conecta a la base de datos

	$description=mysqli_real_escape_string($con,(strip_tags($_POST["description"],ENT_QUOTES)));
	$amount=floatval($_POST['amount']);
	$category=intval($_POST['category']);
	$date_added=$_POST['date'];
	$date_fac=$_POST['date_fac'];
	$user_id=$_SESSION['user_id'];
	$id_cheque=$_POST['id_cheque'];
	$deducible=boolval($_REQUEST['deducible']);
    $iva=floatval($_POST['monto_iva']);
    $comprobante=$_REQUEST['comprobante'];

	
	$sql="INSERT INTO desglose (description, amount, user_id, category_id, created_at,id_cheque,deducible,iva,date_fac,comprobante) VALUES ('$description','$amount','$user_id,$category','$date_added','$id_cheque','$deducible','$iva','$date_fac')";
	$query_new_insert = mysqli_query($con,$sql);
	if ($query_new_insert){
		$messages[] = "Tu ingreso ha sido ingresado satisfactoriamente.";
	} else{
		$errors []= "Lo siento algo ha salido mal intenta nuevamente.".mysqli_error($con);
	}

	       


		
?>