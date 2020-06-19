<?php 
function sum_expense_month_nc($filtro,$month){
	global $con;
	$year=date('Y');
	//SELECT sum(che.monto) as monto from gastos as gas join cheques as che on che.id=gas.id_cheque where gas.t_gasto=1 and gas.status=1
	$sql=mysqli_query($con,"SELECT sum(che.monto) as total from gastos as gas join cheques as che on che.id=gas.id_cheque join user as usu on usu.id=che.beneficiario where year(gas.fecha) = '$year' and month(gas.fecha)= '$month'  and gas.status=1 $filtro");
	$rw=mysqli_fetch_array($sql);
	echo $total=number_format($rw['total'],2,'.','');
	}
function sum_expenses_month_c($filtro,$month){
	global $con;
	$year=date('Y');
	$consulta="SELECT sum(des.amount+des.iva) as total from desglose as des join cheques as che on che.id=des.id_cheque join user as usu on usu.id=che.beneficiario 
	where ((year(des.created_at) = '$year' and month(des.created_at)= '$month' and des.comprobante!='' $filtro) or (year(des.created_at) = '$year' and month(des.created_at)= '$month' and des.deducible='0' $filtro)) and (des.ok_cli='1') ";

	$sql=mysqli_query($con,$consulta);
	$rw=mysqli_fetch_array($sql);
	echo$total=number_format($rw['total'],2,'.','');
	}
function no_aprobado($filtro)
{
	global $con;
	
	 $consulta="SELECT sum(des.amount+des.iva) as total from desglose as des 
join papelera_desglose p on p.id_desglose=des.id
join cheques as che on che.id=p.id_cheque 
join user as usu on usu.id=che.beneficiario 
where  p.restaurar=0 $filtro ";
    $sql = mysqli_query($con,$consulta );
    $rw=mysqli_fetch_array($sql);
	echo$total=number_format($rw['total'],2,'.','');

}


?>