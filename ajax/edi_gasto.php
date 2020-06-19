<?php
include "../config/config.php";
$id= $_REQUEST['id'];
$consulta="SELECT * from desglose where id='$id' and ok_cli!='1' and ok_sup!='1' and ok_val!='1'  " ;
$datos=mysqli_query($con,$consulta);
//echo "No disponible";
echo $datos=json_encode(mysqli_fetch_array($datos));
?>