<?php
session_start();
include"../config/config.php";
$id=$_SESSION['user_id'];

$consulta="SELECT id from notificaciones where destina='$id' and visto=0";
$sql=mysqli_query($con,$consulta);
$num=mysqli_num_rows($sql);

if(intval($num)>0)
{
	?>
	<img src=" images/exclama.png" height="12px"><font color="#fff"><?php echo "  ".$num;?></font>
	<?php
}
else
{
	echo"";
}
?>