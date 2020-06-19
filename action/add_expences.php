<?php	
	session_start();
	/*Inicia validacion del lado del servidor*/
	if (empty($_POST['date'])) {
           $errors[] = "Fecha vacío";
        } else if (empty($_POST['description'])){
			$errors[] = "Description vacío";
		} else if ($_POST['category']==""){
			$errors[] = "Selecciona la categoria";
		} else if (empty($_POST['amount'])){
			$errors[] = "Precio de venta vacío";
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

		$user_id=$_SESSION['user_id'];

		$sql="INSERT INTO expenses (description, amount, user_id, category_id, created_at) VALUES (\"$description\",\"$amount\",$user_id,$category, \"$date_added\")";
		$query_new_insert = mysqli_query($con,$sql);
			if ($query_new_insert){
				$messages[] = "Tu gasto ha sido ingresado satisfactoriamente.";
			} else{
				$errors []= "Lo siento algo ha salido mal intenta nuevamente.".mysqli_error($con);
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

?>