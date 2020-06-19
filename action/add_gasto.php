<?php	
	session_start();
	/*Inicia validacion del lado del servidor*/
	if($_POST['referencia']!="0")
		{
	if (empty($_POST['date'])) {
           $errors[] = "Fecha vacío";
        } else if (empty($_POST['description'])){
			$errors[] = "Description vacío";
		} else if ($_POST['category']==""){
			$errors[] = "Selecciona la categoria";
		} else if (empty($_POST['amount'])){
			$errors[] = "Cantidad vacío";
		} else if (
			!empty($_POST['date']) &&
			!empty($_POST['description']) &&
			$_POST['category']!="" &&
			!empty($_POST['amount'])
		){

		include "../config/config.php";//Contiene funcion que conecta a la base de datos

		$description=mysqli_real_escape_string($con,(strip_tags($_POST["description"],ENT_QUOTES)));
		$amount=floatval($_POST['amount']);
		$category=intval($_POST['category']);
		$date_added=$_POST['date'];
		$date_fac=$_POST['date_fac'];
		$user_id=$_SESSION['user_id'];
		$id_cheque=$_POST['referencia'];
		$deducible=boolval($_REQUEST['deducible']);
        $iva=floatval($_POST['monto_iva']);

        if(!$deducible)
        {
        	$deducible=0;
        }
        
        

        $verificar="SELECT status from cheques where id='$id_cheque' ";
        $sql=mysqli_query($con,$verificar);
        $verificar=mysqli_fetch_array($sql);
        if(intval($verificar['status'])!=0)
        {
        	echo "#1#No se puede agregar mas, este reembolso ya se solicitó.";
        }else{
        	//Esto el lo ultimo
        	 $consulta="UPDATE cheques set monto=monto+$amount+$iva where id='$id_cheque' and t_cheque='3' ";
        if($query_new_insert = mysqli_query($con,$consulta))
        {
        	?>
				<div class="alert alert-success" role="alert">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<strong>¡Monto actualizado!</strong>
				
			</div>
			<?php
        }
        else
        {
        	?>
			<div class="alert alert-danger" role="alert">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
					<strong>Error!</strong> 
					
			</div>
			<?php
        }

		
		$sql="INSERT INTO desglose (description, amount, user_id, category_id, created_at,id_cheque,deducible,iva,date_fac) VALUES (\"$description\",$amount,$user_id,$category,\"$date_added\",$id_cheque,$deducible,$iva,'$date_fac')";
		$query_new_insert = mysqli_query($con,$sql);
			if ($query_new_insert){
				$messages[] = "Tu ingreso ha sido ingresado satisfactoriamente.";
			} else{
				$errors []= "Lo siento algo ha salido mal intenta nuevamente.".mysqli_error($con);
			}
        	//Esto el lo ultimo
        }

       


		} else {
			$errors []= "Error desconocido.";
		}
		
		if (isset($errors)){
			
			?>
			<div class="alert alert-danger" role="alert">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
					<strong>Error!</strong> 
					<?php
						foreach ($errors as $error) {
								echo $error;
							}
						?>
			</div>
			<?php
			}
			if (isset($messages)){
				
				?>
				<div class="alert alert-success" role="alert">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						<strong>¡Bien hecho!</strong>
						<?php
							foreach ($messages as $message) {
									echo $message;
								}
							?>
				</div>
				<?php
			}
		}else
		{
			?>
				<div class="alert alert-danger" role="alert">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
					<strong>Error! No has seleccionado un gasto</strong> 
					
			</div>
				<?php
		}

?>