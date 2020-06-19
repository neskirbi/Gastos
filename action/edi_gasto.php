<?php 
include"../config/config.php";
session_start();
$user_id=$_SESSION['user_id'];
$id_cheque=$_REQUEST['referencia'];
$date=$_REQUEST['date'];
$description=mysqli_real_escape_string($con,(strip_tags($_REQUEST["description"],ENT_QUOTES)));
$amount=floatval($_REQUEST['amount']);
$deducible=boolval($_REQUEST['deducible']);
$iva=floatval($_REQUEST['monto_iva']);
$category=intval($_REQUEST['category']);


$consulta="UPDATE desglose set description='$description', amount=$amount,  category_id=$category, created_at='$date',deducible=$deducible,iva=$iva where id=$id_cheque  ";

if($sql=mysqli_query($con,$consulta))
{
	?>
				<div class="alert alert-success" role="alert">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						<strong>¡Se suardaron los cambios!</strong>
				</div>
				<?php
}else
{
	?>
			<div class="alert alert-danger" role="alert">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
					<strong>Error! <?php echo mysqli_error($con);?></strong> 
					
			</div>
			<?php
}

?>