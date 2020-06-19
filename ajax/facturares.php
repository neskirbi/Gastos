<?php
$fecha=explode("-",$_REQUEST['mes']);
$month=$fecha[0];
$year=$fecha[1];

include "../config/config.php";
session_start();

  $filtro="where   programa='".$_REQUEST['programa']."' ";


?>

	<button  class="btn btn-default pull-right" onclick="factura();">
		<span class="glyphicon glyphicon-list-alt"></span> Facturar</button>


<table class="table table-striped jambo_table bulk_action" width="50%">
	<thead>
		<tr>
			<th>#</th>
			<th>Nombre</th>
			<th>Monto</th>
			<th>Comprobado</th>
			<th>Deducible</th>
			<th>IVA</th>
			<th>No Deducible</th>
			<th>Total</th>
		</tr>
	</thead>
	<?php
	$t1=array();
	$t2=array();
	$t3=array();
	$t4=array();
	$t5=array();
	$t6=array();
	$t7=array();	
	$idt=array();
	$consulta="SELECT * from user   $filtro";
	$sql=mysqli_query($con,$consulta);
	$cont=1;
	while($sql_data=mysqli_fetch_array($sql))
	{
		$consulta="SELECT sum(che.monto) as monto from gastos as gas join cheques as che on che.id=gas.id_cheque  where year(gas.fecha)= '$year' and month(gas.fecha)= '$month' and gas.status=1  and che.beneficiario='".$sql_data['id']."'";
		$sql2=mysqli_query($con,$consulta);
		$total_mes=mysqli_fetch_array($sql2);
		$monto=$total_mes['monto'];

		$cons_compro="SELECT sum(des.amount+des.iva) as desducible,usu.name from desglose as des join cheques as che on che.id=des.id_cheque join user as usu on usu.id=che.beneficiario where (year(des.created_at)='$year' and month(des.created_at)='$month' and des.deducible='1' and usu.id='".$sql_data['id']."') and des.ok_cli='1' ";
        $desducible=mysqli_query($con,$cons_compro);
        $desducible=mysqli_fetch_array($desducible);
        $desducible=$desducible['desducible'];
		

		$cons_compro="SELECT sum(des.amount+des.iva) as no_desducible,usu.name from desglose as des join cheques as che on che.id=des.id_cheque join user as usu on usu.id=che.beneficiario where (year(des.created_at)='$year' and month(des.created_at)='$month' and des.deducible='0' and usu.id='".$sql_data['id']."') and des.ok_cli='1' ";
        $no_desducible=mysqli_query($con,$cons_compro);
        $no_desducible=mysqli_fetch_array($no_desducible);
        $no_desducible=$no_desducible['no_desducible'];

        $cons_compro="SELECT sum(des.amount+des.iva) as comprobado,usu.name from desglose as des join cheques as che on che.id=des.id_cheque join user as usu on usu.id=che.beneficiario where ((year(des.created_at)='$year' and month(des.created_at)='$month'  and usu.id='".$sql_data['id']."') and ((des.deducible='0' and des.comprobante='')or(des.deducible='1' and des.comprobante!=''))) and des.ok_cli='1' ";
        $comprobado=mysqli_query($con,$cons_compro);
        $comprobado=mysqli_fetch_array($comprobado);
        $comprobado=$comprobado['comprobado'];

        $id=array();
        $ids="SELECT des.id from desglose as des join cheques as che on che.id=des.id_cheque join user as usu on usu.id=che.beneficiario where ((year(des.created_at)='$year' and month(des.created_at)='$month'  and usu.id='".$sql_data['id']."') and ((des.deducible='0' and des.comprobante='')or(des.deducible='1' and des.comprobante!=''))) and des.ok_cli='1' and des.facturacion='0'";
        $ids=mysqli_query($con,$ids);

        while($ids_dat=mysqli_fetch_array($ids))
        {
        	$id[]=$ids_dat["id"];
        }
        


        $cons_compro="SELECT sum(des.iva) as iva,usu.name from desglose as des join cheques as che on che.id=des.id_cheque join user as usu on usu.id=che.beneficiario where (year(des.created_at)='$year' and month(des.created_at)='$month' and des.deducible='1' and usu.id='".$sql_data['id']."') and des.ok_cli='1' ";

        $iva=mysqli_query($con,$cons_compro);
        $iva=mysqli_fetch_array($iva);
        $iva=$iva['iva'];
		$t1[]=$monto;
		$t2[]=$comprobado;
		$t3[]=$desducible;
		$t4[]=$iva;
		$t5[]=$no_desducible;
		$t6[]=$desducible+$no_desducible;
		if(count($id)>0)
		{
			$idt[]=implode(",",$id);
		}




		?>
			<tr>
				<td><?php echo $cont; ?></td>
				<td><?php echo $sql_data['name']; ?></td>
				<td><?php echo "$".number_format($monto,2); ?></td>
				<td><?php echo "$".number_format($comprobado,2);?></td>
				<td><?php echo "$".number_format($desducible,2);?></td>
				<td><?php echo "$".number_format($iva,2);?></td>
				<td><?php echo "$".number_format($no_desducible,2);?></td>
				<td><?php echo "$".number_format($desducible+$no_desducible,2); ?></td>
			</tr>
		<?php
		$cont++;
	}
	?>
			<tr>
				<td>Total</td>
				<td><input style="visibility: hidden;" type="text" id="ids" value="<?php  echo implode(',',$idt); ?>"></td>
				<td><?php echo "$".number_format(array_sum($t1),2);?><input style="visibility: hidden;" type="text" id="t1" value="<?php echo array_sum($t1); ?>"></td>
				<td><?php echo "$".number_format(array_sum($t2),2);?><input style="visibility: hidden;" type="text" id="t2" value="<?php echo array_sum($t2); ?>"></td>
				<td><?php echo "$".number_format(array_sum($t3),2);?><input style="visibility: hidden;" type="text" id="t3" value="<?php echo array_sum($t3); ?>"></td>
				<td><?php echo "$".number_format(array_sum($t4),2);?><input style="visibility: hidden;" type="text" id="t4" value="<?php echo array_sum($t4); ?>"></td>
				<td><?php echo "$".number_format(array_sum($t5),2);?><input style="visibility: hidden;" type="text" id="t5" value="<?php echo array_sum($t5); ?>"></td>
				<td><?php echo "$".number_format(array_sum($t6),2);?><input style="visibility: hidden;" type="text" id="t6" value="<?php echo array_sum($t6); ?>"></td>
			</tr>


</table>