<?php

include"../config/config.php";
include"../funciones/funciones.php";
$fechaautorizado=$_REQUEST['fechaautorizado'];
$sql="SELECT che.cuentasalida,pro.cuenta,pro.clavebanco,che.monto,che.FolioSantander,che.fecha,pro.email from cheques as che 
left join proveedores as pro on pro.id = che.beneficiario 
where che.fechaautorizado='$fechaautorizado' and pro.tipocuenta='SANTAN' order by fechaautorizado desc";
$rows = mysqli_query($con,$sql);
$areglo=array();
while ($row=mysqli_fetch_array($rows)){	
	$row['cuentasalida']=Acomodar(("LTX07".$row['cuentasalida']),"r",18," ");
	$row['cuenta']=Acomodar($row['cuenta'],"r",20," ");
	$row['clavebanco']=Acomodar($row['clavebanco'],"r",5," ");
	$row['monto']=Acomodar(($row['monto']*100),"r",18,"0");
	$row['FolioSantander']=Acomodar(Reemplaza($row['FolioSantander']),"r",40," ");
	$row['fecha']=Acomodar(str_replace("-","",$row['fecha']),"r",0,"");
	$row['email']=Acomodar($row['email'],"r",0,"");
	$areglo[]=$row;
}

echo json_encode($areglo);

?>

