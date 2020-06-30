<?php	
	session_start();
	/*Inicia validacion del lado del servidor*/
	include "../config/config.php";//Contiene funcion que conecta a la base de datos
	

	$id_desglose=$_REQUEST['id_desglose'];
	$id_desglose=$_REQUEST['file'];


	$facturat=explode(",",$_REQUEST['file']);
    $facturaname=$facturat[0];
    $factura64=$facturat[1];


    $content = base64_decode($factura64);
    $file = fopen("../Comprobantes/".$facturaname, "wb");
    fwrite($file, $content);
	fclose($file);
	    
	
	$consulta="UPDATE desglose set $campo='$filename' where id='$id_desglose' ' ";
    if($query_new_insert = mysqli_query($con,$consulta))
    {
			echo"1#sep#";
			?>
			<div class="alert alert-success" role="alert">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			<strong>¡Monto actualizado!</strong>
			
		</div>
		<?php
    }else{
    	echo"0#sep#";
    	?>
		<div class="alert alert-danger" role="alert">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
				<strong>Error!</strong> 
				
		</div>
		<?php
    }

	

	
	

	       


		
?>