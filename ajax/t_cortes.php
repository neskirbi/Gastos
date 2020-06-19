<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');
 include "../config/config.php";

$programa= $_REQUEST['programa'];

$consulta="SELECT * from cortes where  programa='$programa'  ";
$sql=mysqli_query($con,$consulta);
?>
<table width="100%"  class="table table-striped">
	<tr>
		<td>Id</td>
		<td>Monto</td>
		<td>No aprobado</td>
		<td>Deducible</td>
		<td>Periodo</td>
		<td></td>
		<td></td>
	</tr>
<?php

while($sql_data=mysqli_fetch_array($sql))
{
?>
	<tr>
		<td><?php echo $sql_data['id'];?></td>
		<td>$<?php echo $sql_data['monto'];?></td>
		<td>$<?php echo $sql_data['no_apro'];?></td>
		<td>$<?php echo $sql_data['deducible'];?></td>
		<td><?php echo $sql_data['fecha'];?></td>
		<td><button onclick="imprimir_cor(<?php echo $sql_data['id'];?>);" class="btn btn-primary btn-sm"> Imprimir</button></td>
		<td><button onclick="imprimir_cor_det(<?php echo $sql_data['id'];?>);" class="btn btn-primary btn-sm"> Detalle</button></td>
	</tr>
<?php

}
?>
		
	</table>