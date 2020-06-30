<?php
include "../config/config.php";
$id=$_POST['id'];
$campo=$_POST['campo'];


$nombre_ima=$_POST['nombre_ima'];
$dir_subida = '../comprobantes/';
$nombre=basename($_FILES['imagen']['name']);

$pdf = '.pdf';
$xml=".xml";
$jpg=".jpg";

$PDF = '.PDF';
$XML=".XML";
$JPG=".JPG";


if ((strpos($nombre,$pdf ) !== false)||(strpos($nombre,$PDF ) !== false)) 
{
	$nombre_ima=$nombre_ima.".pdf";
}

if ((strpos($nombre,$xml ) !== false)||(strpos($nombre,$XML ) !== false)) 
{
	$nombre_ima=$nombre_ima.".xml";
}

if ((strpos($nombre,$jpg ) !== false)||(strpos($nombre,$JPG ) !== false)) 
{
	$nombre_ima=$nombre_ima.".jpg";
}

$fichero_subido = $dir_subida . $nombre_ima;
if(!file_exists($fichero_subido)){

if (strpos($nombre,$pdf ) !== false || strpos($nombre,$xml) !== false||strpos($nombre,$jpg ) !== false ||strpos($nombre,$PDF ) !== false || strpos($nombre,$XML ) !== false || strpos($nombre,$JPG ) !== false) {
    $consulta="UPDATE desglose set $campo='$nombre_ima' where id=$id ";
	if($sql=mysqli_query($con,$consulta))
    {
    	
			if (move_uploaded_file($_FILES['imagen']['tmp_name'], $fichero_subido)) {
			    ;
			    
			    ?>
			    	<div class="alert alert-success" role="alert">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						<strong>¡El fichero es válido y se subió con éxito.!</strong>
						</div>
					<?php
			} else {
				?>

		<div class="alert alert-danger" role="alert">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<strong>¡Error de subida de ficheros!</strong>
		</div>
		<?php
			}

		

    }else
    {
    	?>

		<div class="alert alert-danger" role="alert">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<strong>¡Error al guardar.!</strong>
		</div>
		<?php
    }
	
}else
{
	 ?>

		<div class="alert alert-danger" role="alert">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<strong>¡El fichero no válido, solo .pdf  &oacute; .xml  !</strong>
		</div>
	<?php
}


}else{
			?>

		<div class="alert alert-danger" role="alert">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<strong>¡Error, ya existe un fichero con el mismo nombre.!</strong>
		</div>
		<?php
		}

   
?>