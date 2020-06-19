<?php 
session_start();
include "../config/config.php";



$programa=$_REQUEST["programa"];

$consulta="
SELECT
(
SELECT round(sum(des.amount))
from desglose as des 
join cheques as che on che.id=des.id_cheque and che.programa='$programa'
where des.ok_cli='1' and des.facturacion ='0'
) as monto,

(
SELECT round( sum(des.iva))
from desglose as des 
join cheques as che on che.id=des.id_cheque and che.programa='$programa'
where des.ok_cli='1' and des.facturacion ='0'
) as iva,
(
SELECT round(sum(des.amount) + sum(des.iva)) 
from desglose as des 
join cheques as che on che.id=des.id_cheque and che.programa='$programa'
where des.ok_cli='1' and des.facturacion ='0' and des.deducible='1'
) as dedu,
(
SELECT round(sum(des.amount) + sum(des.iva))  
from desglose as des 
join cheques as che on che.id=des.id_cheque and che.programa='$programa'
where des.ok_cli='1' and des.facturacion ='0' and des.deducible='0'
) as no_dedu,
(
SELECT round(sum(des.amount) + sum(des.iva)) 
from desglose as des 
join cheques as che on che.id=des.id_cheque and che.programa='$programa'
where des.ok_cli='0' and des.facturacion ='0'
) as no_apro,
(
SELECT GROUP_CONCAT(des.id ORDER BY des.id ASC SEPARATOR ',')
   from desglose as des 
join cheques as che on che.id=des.id_cheque and che.programa='$programa'
where des.ok_cli='1' and des.facturacion ='0')  As ids



";

$sql=mysqli_query($con,$consulta);
$datos=mysqli_fetch_array($sql);
$t1=$datos["monto"];
$t2=$datos["iva"];
$t3=$datos["dedu"];
$t4=$datos["no_dedu"];
$t5=$datos["no_apro"];
$ids=$datos["ids"];

$t6=$t1+$t2;


$fecha=date("Y-m-d/H:i:s");
//values('21618','3275','24793','100','1499','24893','04-2018','2018-05-28/17:42:53','1')
$consulta="INSERT into cortes (monto,iva,deducible,no_deducible,no_apro,total,fecha,programa, fecha_corte) values('$t1','$t2','$t3','$t4','$t5','$t6','$fecha','$programa', LAST_DAY(CURDATE())";

if($sql=mysqli_query($con,$consulta))
{
	$last_id = mysqli_insert_id($con);
	$ids="'".str_replace("," , "','" , $ids)."'";
    if( intval($last_id)>0)
    {
    	$consulta="UPDATE desglose set facturacion='$last_id' where ok_cli='1' and id in($ids) ";
    	if($res=mysqli_query($con,$consulta))
    	{
			?> 
			<div class="alert alert-success" role="alert">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<strong>¡Correcto!</strong>: Se factur&oacute; Correctamente <?php echo $mes; 
				?>
			</div>
			<?php    		
    	}else
    	{
    		?> 
				<div class="alert alert-danger" role="alert">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					<strong>¡Error!, No reintentar Comunicarse con el area de sistemas. </strong>
					<?php
						echo mysqli_error($con);
					?>
				</div>
				<?php
    	}

    }

	?> 
	<div class="alert alert-success" role="alert">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<strong>¡Correcto!</strong>: Se genero el corte de (pro) del periodo <?php echo $mes; 
		?>
	</div>
	<?php
}else
{
	?> 
	<div class="alert alert-danger" role="alert">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						<strong>¡Error! </strong>
						<?php
									echo mysqli_error($con);
							?>
				</div>
<?php
}

?>