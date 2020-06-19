<?php
 include "../config/config.php";
$id = $_REQUEST['id'];

$consulta="SELECT * from cortes where id='$id'   ";
$sql=mysqli_query($con,$consulta);
?>
<table width="100%" border="1">
<?php

while($sql_data=mysqli_fetch_array($sql))
{
?>
	<tr>
		<td><?php echo $sql_data['id'];?></td>
		<td><?php echo $sql_data['monto'];?></td>
		<td><?php echo $sql_data['comprobado'];?></td>
		<td><?php echo $sql_data['deducible'];?></td>
	</tr>
<?php

}
?>
		
	</table>