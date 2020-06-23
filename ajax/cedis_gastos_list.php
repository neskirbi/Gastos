<?php
include"../config/config.php";

$id_se_cobra_a=$_REQUEST['id_se_cobra_a'];

$consulta="SELECT * from cedis_gastos where id_se_cobra_a='$id_se_cobra_a' order by id_se_cobra_a asc";
$sql=mysqli_query($con,$consulta);
$result=array();
while ($row=mysqli_fetch_array($sql)) 
{
   $result[]=$row;
}

echo json_encode($result);
?>