<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
include"../config/config.php";
$id=$_REQUEST['id'];



	 $consulta="SELECT id_cheque from desglose where id='$id' ";

	$sql=mysqli_query($con,$consulta);

	$sql_data=mysqli_fetch_array($sql);
	

	echo $sql_data['id_cheque'];

?>