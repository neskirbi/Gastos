<?php

	if (empty($_POST['mod_id'])) {
           $errors[] = "ID vacío";
        }else if (empty($_POST['mod_description'])){
			$errors[] = "Descripción vacío";
		} else if ($_POST['mod_category']==""){
			$errors[] = "Selecciona una categoria";
		} else if (empty($_POST['mod_amount'])){
			$errors[] = "Cantidad Vacio";
		} else if (
			!empty($_POST['mod_description']) &&
			!empty($_POST['mod_amount']) &&
			$_POST['mod_category']!=""
		){

		include "../config/config.php";//Contiene funcion que conecta a la base de datos

		$description=mysqli_real_escape_string($con,(strip_tags($_POST["mod_description"],ENT_QUOTES)));
		$amount=floatval($_POST['mod_amount']);
		$category=intval($_POST['mod_category']);
		
		$id=$_POST['mod_id'];

		$sql="UPDATE income SET  description=\"$description\", amount=$amount, category_id=$category WHERE id=$id ";
		$query_update = mysqli_query($con,$sql);
			if ($query_update){
				$messages[] = "EL ingreso ha sido actualizado satisfactoriamente.";
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