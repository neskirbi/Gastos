<?php
include"../config/config.php";
session_start();

$user_id=$_SESSION['user_id'];
$user_tipo=$_SESSION['user_tipo'];
$programa=$_POST['programa'];
$monto=$_POST['monto'];
$fecha=$_POST['fecha'];
$idben=$_POST['idben'];
$bennombre=$_POST['nombreben'];
$clasifica=$_POST['clasificacion'];
$tipopago=$_POST['tipopago'];

$concepto=mysqli_real_escape_string($con,( $_POST['concepto']));
$se_cobra_a_list=mysqli_real_escape_string($con,$_POST['se_cobra_a_list']);
$cedis_gastos_list=mysqli_real_escape_string($con,$_POST['cedis_gastos_list']);
$FolioSantander=mysqli_real_escape_string($con,$_POST['FolioSantander']);
$semana=mysqli_real_escape_string($con,( $_POST['semana']));
$periodo=mysqli_real_escape_string($con,( $_POST['periodo']));
$Cuenta=mysqli_real_escape_string($con,( $_POST['Cuenta']));

$category=$_POST['category'];

if($idben=="0")
{
	$idben=$user_id;
}
$status=1;
if($category=="3")
{
	$status=0;
}

$consulta="INSERT into cheques (programa,monto,fecha,fecha_confirm,beneficiario,bennombre,concepto,t_cheque,status,no_cheque,solicitante,clasificacion,a_iva, semana, periodo, tipopago, cuenta,se_cobra_a_list,cedis_gastos_list,FolioSantander) values($programa,$monto,'$fecha','$fecha',$idben,'$bennombre','$concepto',$category,$status, '0', '$user_id', '$clasifica',0,'$semana', '$periodo', '$tipopago', '$Cuenta','$se_cobra_a_list','$cedis_gastos_list','$FolioSantander')";
if($sql=mysqli_query($con,$consulta))
{
	$idcheque= mysqli_insert_id($con);
	?>
	<div class="alert alert-success" role="alert">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<strong>¡Bien hecho! Cheque solicitado ,<?php echo $idcheque; ?>, </strong>
		
	</div>
	<?php
	//si es un reembolso se carga el gasto en automatico
	if($category=="3")
	{
		
		$fecha_confirm=date('Y-m-d');
		$consulta="INSERT into gastos (id_cheque,fecha,fecha_comp,status,t_gasto) values('$idcheque','$fecha_confirm','0000-00-00','1','0')";
        if(mysqli_query($con,$consulta))
            {
              ?>
            <div class="alert alert-success alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong>Aviso!</strong> Reembolso solicitado.
            </div>
            <?php
        }else{
        	?>
			<div class="alert alert-error" role="alert">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<strong>¡Error!, Al cargar el gasto</strong>
			</div>
		<?php
        }
	}

	}else{
		?>
		<div class="alert alert-error" role="alert">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			<strong>¡Error!, Verifique los datos</strong>
			
		</div>
		<?php
	}
?>


				