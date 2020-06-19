<?php
include"../config/config.php";
$id=$_REQUEST['id'];

$consulta="SELECT c.programa,d.amount,d.iva,c.solicitante,c.beneficiario,c.bennombre,c.concepto,c.t_cheque,c.status,c.clasificacion,c.a_iva from desglose as d join papelera_desglose as dd on dd.id_desglose=d.id join cheques as c on c.id=dd.id_cheque  where d.id='$id' ";
$sql=mysqli_query($con,$consulta);
$row=mysqli_fetch_array($sql);
//print_r($row);

$programa=$row['programa'];
$solicitante=$row['solicitante'];
$beneficiario=$row['beneficiario'];
$bennombre=$row['bennombre'];
$concepto=$row['concepto'];
$programa=$row['programa'];
$t_cheque=$row['t_cheque'];
$status=$row['status'];
$clasificacion=$row['clasificacion'];
$a_iva=$row['a_iva'];
$monto=$row['amount']+$row['iva'];
$fecha=date('Y-m-d');
$fecha_confirm='';

$consulta="INSERT into cheques (no_cheque,programa,monto,fecha,fecha_confirm,solicitante,beneficiario,bennombre,concepto,t_cheque,status,clasificacion,a_iva) values (0,$programa,$monto,'$fecha','$fecha_confirm','$solicitante','$beneficiario','$bennombre','$concepto','$t_cheque','1','$clasificacion','$a_iva')";

if (mysqli_query($con,$consulta)) 
{
		
	$idcheque= mysqli_insert_id($con);

	$consulta="INSERT into gastos (id_cheque,fecha,fecha_comp,status,t_gasto) values('$idcheque','$fecha','$fecha','1','0')";
	if (mysqli_query($con,$consulta)) 
	{
		 mysqli_insert_id($con);

		$consulta="SELECT * from desglose  where id='$id' ";
		$sql=mysqli_query($con,$consulta);
		$row=mysqli_fetch_array($sql);




		$description= $row['description'];
		$amount= $row['amount'];
		$user_id= $row['user_id'];
		$category_id= $row['category_id'];
		$created_at= $fecha;
		$id_cheque= $idcheque;
		$comprobante= $row['comprobante'];
		$deducible= $row['deducible'];
		$iva= $row['iva'];
		$quien_sup= $row['quien_sup'];
		$com_sup= $row['com_sup'];
		$ok_sup= $row['ok_sup'];
		$quien_cli= $row['quien_cli'];
		$com_cli= $row['com_cli'];
		$ok_cli= $row['ok_cli'];
		$quien_val= $row['quien_val'];
		$com_val= $row['com_val'];
		$o_impuestos= $row['o_impuestos'];
		$ret_iva= $row['ret_iva'];
		$facturacion= $row['facturacion'];
		$ok_val= $row['ok_val'];
		$si_aid= $row['si_aid'];
		$fecha_ok_sup= $row['fecha_ok_sup'];
		$fecha_ok_cli= $row['fecha_ok_cli'];

		$consulta="INSERT into desglose (description,amount,user_id,category_id,created_at,id_cheque,comprobante,deducible,iva,quien_sup,com_sup,ok_sup,quien_cli,com_cli,ok_cli,quien_val,com_val,o_impuestos,ret_iva,facturacion,ok_val,si_aid,fecha_ok_sup,fecha_ok_cli) values('$description','$amount','$user_id','$category_id','$fecha','$id_cheque','$comprobante','$deducible','$iva',0,'','0',0,'','0',0,'','$o_impuestos','$ret_iva','0','0','0','$fecha_ok_sup','$fecha_ok_cli')";

		if (mysqli_query($con,$consulta)) 
		{

			echo"Se restauro correctamente!";

			$consulta="UPDATE papelera_desglose set  restaurar='1'  where id_desglose='$id' ";
			mysqli_query($con,$consulta);



		}else{
				echo "1.-\n".mysqli_error($con);
		}

		
	}else
	{
		echo "2.-\n".mysqli_error($con);
	}

}else
{
	echo "3.-\n".mysqli_error($con);
}

	

?>