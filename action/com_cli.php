<?php
include "../config/config.php";
$id= $_REQUEST['id'];
$comen=mysqli_real_escape_string($con,(strip_tags($_REQUEST['comen'],ENT_QUOTES)));
$consulta="UPDATE desglose set com_cli='$comen' where id='$id'";

if($sql=mysqli_query($con,$consulta))
{
	echo "1";
}else
{
	echo"0";
}
?>