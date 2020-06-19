<?php
include "../../config/config.php";//Contiene funcion que conecta a la base de datos
session_start();
$programa=$_REQUEST['programa'];
$rutas=$_REQUEST['rutas'];
$rutas="'".str_replace(",", "','", $rutas)."'";

if($_SESSION['user_tipo']=='5')
{
	$consulta="SELECT name,id from user where rutas in ($rutas) and programa ='$programa'";
}else{
	$consulta="SELECT name,id from user where  programa ='$programa' and tipo='5'" ;
}




$sql=mysqli_query($con,$consulta);
?>

<?php
while($r=mysqli_fetch_array($sql))
{
	?>

	<a href="#" onclick="chat(<?php echo $r['id']; ?>,this);"><?php echo utf8_encode($r['name']); ?></a><br>

	<?php

}

?>