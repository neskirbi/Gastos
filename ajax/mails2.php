<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
include"../config/config.php";
$id=$_REQUEST['id'];



	 $consulta="SELECT us.id,us.email,usu.name,che.monto from cheques as che
	 join user as usu on usu.id=che.beneficiario 
	 join user as us on us.rutas  like CONCAT('%',usu.rutas, '%') and us.programa=usu.programa
	 where che.id='$id' and  (us.tipo='3' or us.tipo='5') " ;

	$sql=mysqli_query($con,$consulta);
	$mails=array();
	$mails[0][0]="56";
	while($sql_data=mysqli_fetch_array($sql))
	{
		$mails[0] [] =$sql_data['id'];
		$mails[1] [] =$sql_data['name'];
		$mails[2] [] =$sql_data['monto'];

	}

	echo json_encode( $mails);

?>