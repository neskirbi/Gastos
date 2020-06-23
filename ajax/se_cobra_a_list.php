<?php
include"../config/config.php";

$consulta="SELECT * from se_cobra_a order by id_se_cobra_a asc";

$sql=mysqli_query($con,$consulta);
$result=array();
while ($row=mysqli_fetch_array($sql)) 
{
   $result[]=$row;
}

echo json_encode($result);
?>